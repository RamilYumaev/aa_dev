<?php

namespace common\auth\models;

use common\auth\forms\SignupForm;
use common\auth\forms\UserEmailForm;

use common\auth\forms\UserEditForm as UserDefault;
use olympic\forms\auth\UserEditForm;
use olympic\forms\auth\UserCreateForm;
use common\auth\helpers\UserHelper;
use olympic\models\auth\AuthAssignment;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord
{

    private $assignment;

    public function __construct($config = [])
    {
        $this->assignment = new AuthAssignment();
        parent::__construct($config);
    }

    public function setAssignment($addRole)
    {
        foreach (AuthAssignment::getRoleName($this->id) as $role) {
            if ($addRole !== $role) {
                $this->assignment->user_id = $this->id;
                $this->assignment->item_name = $addRole;
                $this->assignment->created_at = time();
                $this->assignment->save();
            }
        }
    }

    public function setAssignmentFirst($addRole)
    {
        $this->assignment->user_id = $this->id;
        $this->assignment->item_name = $addRole;
        $this->assignment->created_at = time();
        $this->assignment->save();
    }

    public static function create(UserCreateForm $form, $github = null): self
    {
        $user = new static();
        $user->username = $form->username;
        $user->email = $form->email;
        $user->github = $github;
        $user->setPassword(!empty($form->password) ? $form->password : Yii::$app->security->generateRandomString());
        $user->created_at = time();
        $user->status = UserHelper::STATUS_WAIT;
        $user->auth_key = Yii::$app->security->generateRandomString();
        return $user;
    }

    public function edit(UserEditForm $form): void
    {
        $this->username = $form->username;
        $this->email = $form->email;
        $this->updated_at = time();
    }

    public function editDefault(UserDefault $form): void
    {
        $this->username = $form->username;
        $this->email = $form->email;

        $this->generateAuthKey();
        $this->generateEmailVerificationToken();

        if ($this->oldAttributes["email"] !== $form->email) {
            $this->status = UserHelper::STATUS_WAIT;
        }
        $this->updated_at = time();
    }


    public function send(): void
    {
        $this->generateAuthKey();
        $this->generateEmailVerificationToken();
    }



    public function addEmail(UserEmailForm $form): void
    {
        $this->username = $form->username;
        $this->email = $form->email;
        if  ($this->oldAttributes["email"] !== $form->email) {
            $this->status = UserHelper::STATUS_WAIT;
        }
        $this->updated_at = time();
    }

    public static function requestSignup(SignupForm $form): self
    {
        $user = new static();
        $user->username = $form->username;
        $user->email = $form->email;
        $user->setPassword($form->password);
        $user->created_at = time();
        $user->status = UserHelper::STATUS_WAIT;
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        return $user;
    }

    public function confirmSignup(): void
    {
        if (!$this->isWait()) {
            throw new \DomainException('Учетная запись уже подтверждена!');
        }
        $this->status = UserHelper::STATUS_ACTIVE;
    }

    public function requestPasswordReset(): void
    {
        if (!empty($this->password_reset_token) && self::isPasswordResetTokenValid($this->password_reset_token)) {
            throw new \DomainException('Сброс пароля уже запрошен.');
        }
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function resetPassword($password): void
    {
        if (empty($this->password_reset_token)) {
            throw new \DomainException('Сброс пароля не запрашивался!');
        }
        $this->setPassword($password);
        $this->password_reset_token = null;
    }

    public function isWait(): bool
    {
        return $this->status === UserHelper::STATUS_WAIT;
    }

    public function isActive(): bool
    {
        return $this->status === UserHelper::STATUS_ACTIVE;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => UserHelper::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => UserHelper::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token)
    {
        return static::findOne([
            'verification_token' => $token,
            'status' => UserHelper::STATUS_INACTIVE
        ]);
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    private function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function attributeLabels()
    {
        return [
            'username'=> 'Логин',
            'email'=> 'Адрес электронной почты',
        ];
    }
}
