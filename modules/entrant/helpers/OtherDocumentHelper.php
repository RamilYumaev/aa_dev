<?php
namespace modules\entrant\helpers;
use common\helpers\EduYearHelper;
use modules\entrant\models\Agreement;
use modules\entrant\models\OtherDocument;

class OtherDocumentHelper
{
    public static function isExitsExemption($user_id): bool
    {
        return OtherDocument::find()->andWhere(['user_id' => $user_id, 'exemption_id'=> true])->exists();
    }

    public static function isExitsPatriot($user_id): bool
    {
        return OtherDocument::find()->andWhere(['user_id' => $user_id,'type'=> 43])->exists();
    }
}