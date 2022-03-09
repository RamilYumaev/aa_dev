<?php

namespace modules\literature\forms;

use common\auth\models\User;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $email;
    public $password;
    public $password_repeat;

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
            [['email'], 'unique', 'targetClass' => \common\auth\models\User::class, 'message' => 'Этот адрес электронной почты уже существует.'],
            [['password', 'password_repeat'], 'required'],
            [['password', 'password_repeat'], 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute' => 'password',
                'message' => "Пароли не совпадают.", 'skipOnEmpty' => false,
                'when' => function ($model) {
                    return $model->password !== null && $model->password !== '';
                },
            ],

        ];
    }

    public function attributeLabels(): array
    {
        return [
            'email' => 'Адрес электронной почты:',
            'password' => 'Придумайте пароль',
            'password_repeat' => 'Повтор пароля',
        ];

    }
}