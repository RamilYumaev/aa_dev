<?php
namespace modules\entrant\helpers;
use modules\entrant\models\AdditionalInformation;

class AdditionalInformationHelper
{
    public static function isExits($user_id): bool
    {
        return AdditionalInformation::find()->andWhere(['user_id' => $user_id])->exists();
    }

    public static function dataArray($userId)
    {
        return AdditionalInformation::findOne(['user_id' => $userId])->dataArray();
    }

}