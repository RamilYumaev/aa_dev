<?php


namespace common\forms\auth;


use common\models\auth\User;
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
                'message' => 'There is no user with this email address.'
            ],
        ];
    }
}
