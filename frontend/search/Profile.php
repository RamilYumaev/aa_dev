<?php

namespace frontend\search;

use olympic\models\auth\Profiles;
use yii\base\Model;

class Profile extends Model
{
    public $last_name,
        $first_name,
        $patronymic,
        $phone,
        $email;

    public function rules()
    {
        return [
            [['lastName', 'firstName', 'patronymic' , 'phone', 'email'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return Profiles::labels();
    }

    public function formName()
    {
        return '';
    }
}