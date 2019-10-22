<?php
namespace common\forms\auth;

use common\models\auth\User;
use yii\base\Model;

/**
 * Signup form
 */

class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $retypePassword;
    public $verifyCode;
    public $agree;

    /**
     * @inheritdoc
     */
    public function rules() :array
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => User::class, 'message' => 'Этот логин уже существует'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'Этот адрес электронной почты уже существует'],

            [['password','retypePassword'], 'required'],
            [['password','retypePassword'], 'string', 'min' => 6],

            ['verifyCode', 'captcha'],
            ['agree', 'required', 'requiredValue' => true, 'message' => 'Согласитесь, пожалуйста, с обработкой персональных данных, 
            поставив соответствующую "галочку"'],

        ];
    }

    public function attributeLabels(): array
    {
        return [
            'username' => 'Логин',
            'email' => 'Почта (e-mail)',
            'password' => 'Пароль',
            'retypePassword' => 'Повторите пароль',
            'verifyCode' => 'Введите код с картинки',
            'agree' => 'Я согласен (согласна) на обработку моих персональных данных',
        ];

    }
}