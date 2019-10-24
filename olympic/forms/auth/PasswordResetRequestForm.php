<?php


namespace olympic\forms\auth;


use olympic\models\auth\User;
use yii\base\Model;

class PasswordResetRequestForm extends Model
{
    public $email;

    public function rules(): array
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => User::class,
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'Нет пользователя с этим адресом электронной почты.'
            ],
        ];
    }
}
