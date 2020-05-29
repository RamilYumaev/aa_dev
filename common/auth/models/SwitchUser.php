<?php


namespace common\auth\models;


use common\auth\helpers\UserHelper;
use yii\base\Model;

class SwitchUser extends Model
{
    public $userId;
    public $submittedStatus;
    public $countryId;
    public $regionId;

    public function rules()
    {
        return [
            [['userId', 'submittedStatus', 'countryId', 'regionId'], 'integer'],
            ['userId', 'exist', 'targetClass' => User::class, 'message' => 'В системе нет такого пользователя'],
            [['userId', 'submittedStatus', 'countryId'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'userId' => 'Какие ФИО пользователь указал в профиле?',
            'submittedStatus' => 'Подтвердил ли пользователь свою электронную почту?',
            'countryId' => 'Какую страну указал пользователь в профиле?',
            'regionId' => 'Какой регион указал пользователь в профиле?',
        ];
    }

    public static function submittedStatus()
    {
        return [UserHelper::STATUS_ACTIVE => 'Да', UserHelper::STATUS_WAIT => 'Нет'];
    }

}