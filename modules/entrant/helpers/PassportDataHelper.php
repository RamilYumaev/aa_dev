<?php
namespace modules\entrant\helpers;

use modules\dictionary\helpers\DictDefaultHelper;
use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\entrant\models\OtherDocument;
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

    public static function isDocumentBirthday($user_id): bool
    {
        return PassportData::find()
            ->andWhere(['user_id' => $user_id,'type' =>
                [DictIncomingDocumentTypeHelper::ID_BIRTH_DOCUMENT,
                    DictIncomingDocumentTypeHelper::ID_BIRTH_FOREIGNER_DOCUMENT]])->exists();
    }


}