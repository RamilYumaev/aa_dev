<?php

namespace common\auth\helpers;

use common\auth\models\SettingEmail;
use common\auth\models\UserSchool;
use dictionary\helpers\DictSchoolsHelper;
use yii\helpers\ArrayHelper;

class SettingEmailHelper
{

    public static function all(): array
    {
        return  ArrayHelper::map(SettingEmail::find()->where(['status' => SettingEmail::ACTIVATE])->all(), 'id', function (SettingEmail $model) {
               return $model->profile->fio .' - '. $model->username;
        });
    }
}