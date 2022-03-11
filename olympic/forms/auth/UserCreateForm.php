<?php


namespace olympic\forms\auth;

use common\auth\models\User;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class UserCreateForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $status;
    public $role;

    public function rules(): array
    {
        return [
            [['username', 'email', 'status'], 'required'],
            ['email', 'email'],
            [['username', 'email'], 'string', 'max' => 255],
            [['username', 'email'], 'unique', 'targetClass' => \common\auth\models\User::class],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function rolesList(): array
    {
        return ArrayHelper::map(\Yii::$app->authManager->getRoles(), 'name', 'description');
    }

    public function attributeLabels()
    {
        return ['password' => "Пароль", 'username' => "Логин", "Статус"=> "Статус"];
    }

}