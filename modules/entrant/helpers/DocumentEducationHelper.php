<?php
namespace modules\entrant\helpers;
use common\helpers\EduYearHelper;
use modules\entrant\models\Agreement;
use modules\entrant\models\DocumentEducation;
use modules\entrant\models\OtherDocument;

class DocumentEducationHelper
{
    public static function isDataNoEmpty($user_id): bool
    {
        return DocumentEducation::findOne(['user_id' => $user_id])->isDataNoEmpty();
    }
}