<?php


namespace common\auth\models;


use yii\base\Model;

class SwitchUser extends Model
{
    public $userId;

    public function rules()
    {
        return [
            ['userId', 'integer'],
            ['userId', 'exist', 'targetClass' => User::class],
            ['userId', 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'userId' => 'Выберите учетную запись пользователя',
        ];
    }

}