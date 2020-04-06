<?php
namespace modules\entrant\helpers;

use modules\dictionary\helpers\DictDefaultHelper;
use modules\entrant\models\PassportData;

class PassportDataHelper
{
    public static function isExits($user_id): bool
    {
        return PassportData::find()->andWhere(['user_id' => $user_id, 'main_status' => DictDefaultHelper::YES])->exists();
    }


}