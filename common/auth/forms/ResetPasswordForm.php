<?php


namespace common\auth\forms;


use yii\base\Model;

class ResetPasswordForm extends Model
{
    public $password;

    public function rules()
    {
        return [
            [['password', 'password_repeat'], 'required'],
            [['password', 'password_repeat'], 'string', 'min' => 6],
            [
                'password_repeat', 'compare', 'compareAttribute' => 'password',
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
            'password' => 'Придумайте пароль',
            'password_repeat' => 'Повтор пароля',
        ];

    }
}
