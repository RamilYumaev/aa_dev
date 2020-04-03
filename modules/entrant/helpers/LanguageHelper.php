<?php
namespace modules\entrant\helpers;

use modules\entrant\models\Language;


class LanguageHelper
{


    public static function isExits($user_id): bool
    {
        return Language::find()->andWhere(['user_id' => $user_id])->exists();
    }


}