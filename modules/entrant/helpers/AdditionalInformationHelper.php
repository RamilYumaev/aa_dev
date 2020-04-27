<?php
namespace modules\entrant\helpers;
use common\helpers\EduYearHelper;
use modules\entrant\models\AdditionalInformation;
use modules\entrant\models\Agreement;

class AdditionalInformationHelper
{
    public static function isExits($user_id): bool
    {
        return AdditionalInformation::find()->andWhere(['user_id' => $user_id])->exists();
    }
}