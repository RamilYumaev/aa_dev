<?php

namespace common\auth\forms;

use common\auth\models\User;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password_repeat;
    public $verifyCode;
    public $agree;

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [

            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => User::class, 'message' => 'Этот логин уже существует.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'Этот адрес электронной почты уже существует.'],

            [['password', 'password_repeat'], 'required'],
            [['password', 'password_repeat'], 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute' => 'password',
                'message' => "Пароли не совпадают.", 'skipOnEmpty' => false,
                'when' => function ($model) {
                    return $model->password !== null && $model->password !== '';
                },
            ],
            ['verifyCode', 'captcha', 'captchaAction' => 'sign-up/captcha'],
            ['agree', 'required', 'requiredValue' => true, 'message' => 'Согласитесь, пожалуйста, с обработкой персональных данных, поставив соответствующую "галочку"'],

        ];
    }

    public function attributeLabels(): array
    {
        return [
            'username' => 'Придумайте логин для личного кабинета (это может быть ваш email)',
            'email' => 'Адрес электронной почты:',
            'password' => 'Придумайте пароль',
            'password_repeat' => 'Повтор пароля',
            'verifyCode' => 'Введите код с картинки',
            'agree' => 'Я согласен (согласна) на обработку моих персональных данных',
        ];

    }
}