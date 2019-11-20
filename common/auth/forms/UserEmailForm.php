<?php

namespace common\auth\forms;

use common\auth\models\User;
use yii\base\Model;

class UserEmailForm extends Model
{
    public $email;
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'Этот адрес электронной почты уже существует.'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'email' => 'Адрес электронной почты:',
        ];

    }
}