<?php

namespace common\auth\forms;

use common\auth\models\SettingEmail;
use common\auth\traits\SettingEmailTrait;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class SettingEmailEditForm extends Model
{
    use SettingEmailTrait;
    private $_email;

    public function __construct(SettingEmail $email, $config = [])
    {
        $this->username = $email->username;
        $this->host= $email->host;
        $this->password = $email->password;
        $this->port = $email->port;
        $this->encryption = $email->encryption;
        $this->user_id = $email->user_id;
        $this->_email = $email;
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        $rules = [['user_id', 'unique', 'targetClass'=> SettingEmail::class, 'filter'=>['<>', 'id', $this->_email->id]]];
        return array_merge($rules, $this->validateRules());
    }
}