<?php
namespace modules\entrant\helpers;
use common\helpers\EduYearHelper;
use modules\entrant\models\Agreement;
use modules\entrant\models\DocumentEducation;
use modules\entrant\models\OtherDocument;

class DocumentEducationHelper
{

    private static function model($user_id): ?DocumentEducation
    {
        return DocumentEducation::findOne(['user_id' => $user_id]);
    }

    public static function isDataNoEmpty($user_id): bool
    {
        return self::model($user_id)->isDataNoEmpty();
    }

    public static function dataArray($user_id): array
    {
        return self::model($user_id)->dataArray();
    }
}