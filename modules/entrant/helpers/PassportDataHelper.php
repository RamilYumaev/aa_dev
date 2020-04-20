<?php
namespace modules\entrant\helpers;

use modules\dictionary\helpers\DictDefaultHelper;
use modules\entrant\models\PassportData;

class PassportDataHelper
{

    public static function model($user_id): ?PassportData
    {
        return PassportData::findOne(['user_id' => $user_id, 'main_status' => DictDefaultHelper::YES]);
    }
    public static function isExits($user_id): bool
    {
        return self::model($user_id) ? true : false;
    }

    public static function dataArray($user_id): array
    {
        return self::model($user_id)->dataArray();
    }


}