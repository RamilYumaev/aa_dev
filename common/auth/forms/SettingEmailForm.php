<?php

namespace common\auth\forms;

use common\auth\models\SettingEmail;
use yii\base\Model;

class SettingEmailForm extends Model
{
    public $username;
    public $host;
    public $password;
    public $port;
    public $encryption;
    public $user_id;

    public function __construct(SettingEmail $email = null, $config = [])
    {
        if ($email) {
            $this->username = $email->username;
            $this->host= $email->host;
            $this->password = $email->password;
            $this->port = $email->port;
            $this->encryption = $email->encryption;
            $this->user_id = $email->user_id;
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
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