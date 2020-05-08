<?php
namespace modules\entrant\helpers;
use modules\entrant\models\FIOLatin;

class FioLatinHelper
{
    public static function isExits($user_id): bool
    {
        return FIOLatin::find()->andWhere(['user_id' => $user_id])->exists();
    }
}