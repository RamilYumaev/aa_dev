<?php
namespace modules\entrant\helpers;

use modules\entrant\models\PassportData;

class LanguageHelper
{
    public static function isExits($user_id): bool
    {
        return PassportData::find()->andWhere(['user_id' => $user_id])->count();
    }


}