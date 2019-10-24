<?php
<<<<<<< HEAD:common/forms/auth/LoginForm.php

namespace common\forms\auth;
=======
namespace olympic\forms\auth;
>>>>>>> #10:olympic/forms/auth/LoginForm.php

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
