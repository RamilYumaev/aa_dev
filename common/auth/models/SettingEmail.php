<?php
namespace common\auth\models;
use common\auth\forms\SettingEmailCreateForm;
use common\auth\forms\SettingEmailEditForm;

/**
 * This is the model class for table "auth".
 *
 * @property int $id
 * @property int $user_id
 * @property string $port
 * @property string $encryption
 * @property string $username
 * @property string $password
 * @property  string $host
 * @property int $status
 *
 */
class SettingEmail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    const ACTIVATE = 1;
    const DRAFT = 0;

    public static function tableName()
    {
        return 'setting_email';
    }

    public static function create($user_id, SettingEmailCreateForm $form) {
        $email = new static();
        $email->user_id = $user_id;
        $email->username = $form->username;
        $email->password = $form->password;
        $email->port = $form->port;
        $email->host = $form->host;
        $email->encryption = $form->encryption;
        return $email;
    }

    public  function edit($user_id, SettingEmailEditForm $form) {
        $this->username = $form->username;
        $this->user_id = $user_id;
        $this->password = $form->password;
        $this->port = $form->port;
        $this->status = self::DRAFT;
        $this->host = $form->host;
        $this->encryption = $form->encryption;
    }

    public function activate() {
        $this->status = self::ACTIVATE;
    }

    public function isActivate() {
        return $this->status == self::ACTIVATE;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Менеджер',
            'username' => 'Email',
            'password' => 'Пароль',
            'host' => "Хостинг почты",
            'port' => "Порт",
            'encryption'=> "Шифрование"
        ];
    }

    public static function labels()
    {
        $email = new static();
        return $email->attributeLabels();

    }

}