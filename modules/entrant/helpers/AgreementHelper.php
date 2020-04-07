<?php
namespace modules\entrant\helpers;
use common\helpers\EduYearHelper;
use modules\entrant\models\Agreement;

class AgreementHelper
{
    public static function isExits($user_id): bool
    {
        return Agreement::find()->andWhere(['user_id' => $user_id, 'year'=> EduYearHelper::eduYear()])->exists();
    }
}