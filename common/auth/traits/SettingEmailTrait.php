<?php
namespace common\auth\traits;

use common\auth\models\SettingEmail;

trait SettingEmailTrait
{
    public $username;
    public $host;
    public $password;
    public $port;
    public $encryption;
    public $user_id;

    public function validateRules(): array
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'email'],
            ['username', 'string','max' => 100],

            ['password', 'trim'],
            ['password', 'required'],
            ['password', 'string','max' => 100],
            ['user_id', 'required'],
            ['user_id', 'integer'],

            ['host', 'trim'],
            ['host', 'required'],
            ['host', 'string','max' => 100],

            ['port', 'trim'],
            ['port', 'required'],
            ['port', 'string','max' => 5],

            ['encryption', 'trim'],
            ['encryption', 'required'],
            ['encryption', 'in', 'range' => $this->encryptionList(), 'allowArray' => true],
        ];
    }

    public function attributeLabels(): array
    {
        return SettingEmail::labels();
    }

    public function encryptionList(): array
    {
        return ['tls'=> 'tls', 'ssl'=> 'ssl'];
    }

}