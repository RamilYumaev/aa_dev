<?php


namespace olympic\forms\auth;


use olympic\helpers\auth\RoleHelper;
use olympic\models\auth\AuthAssignment;
use common\auth\models\User;
use yii\base\Model;

class UserEditForm extends Model
{
    public $username;
    public $email;
    public $status;
    public $role;

    public $_user;

    public function __construct(\common\auth\models\User $user, $config = [])
    {
        $this->username = $user->username;
        $this->email = $user->email;
        $this->status = $user->status;
        $this->role = AuthAssignment::find()->select('item_name')->where(['user_id' => $user->id])->indexBy('item_name')->column();
        $this->_user = $user;
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['username', 'email', 'status'], 'required'],
            ['email', 'email'],
            ['role', 'safe'],
            ['email', 'string', 'max' => 255],
            [['username', 'email'], 'unique', 'targetClass' => User::class, 'filter' => ['<>', 'id', $this->_user->id]],
        ];
    }

    public function rolesList(): array
    {
        return RoleHelper::roleList();
    }

    public function attributeLabels()
    {
        return array_merge((new User())->attributeLabels(), ['role' => 'Роли']);
    }
}