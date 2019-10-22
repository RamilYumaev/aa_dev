<?php
namespace common\forms\auth;

use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean']
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'username' => 'Логин или e-mail',
            'password' => 'Пароль',
            'rememberMe' => 'Запомнить ?'
        ];
    }
}
