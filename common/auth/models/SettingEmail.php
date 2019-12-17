<?php

namespace common\auth\models;

use bar\baz\source_with_namespace;
use common\auth\forms\SettingEmailForm;
use common\auth\models\User;
use Yii;

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
 *
 */
class SettingEmail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'setting_email';
    }

    public static function create($user_id, SettingEmailForm $form) {
        $email = new static();
        $email->user_id = $user_id;
        $email->username = $form->username;
        $email->password = $form->password;
        $email->port = $form->port;
        $email->host = $form->host;
        $email->encryption = $form->encryption;
        return $email;
    }

    public  function edit(SettingEmailForm $form) {
        $this->username = $form->username;
        $this->password = $form->password;
        $this->port = $form->port;
        $this->host = $form->host;
        $this->encryption = $form->encryption;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
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