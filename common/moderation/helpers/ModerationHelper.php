<?php
namespace common\moderation\helpers;

use common\moderation\interfaces\YiiActiveRecordAndModeration;
use common\moderation\models\Moderation;
use modules\entrant\models\AdditionalInformation;
use modules\entrant\models\Address;
use modules\entrant\models\AverageScopeSpo;
use modules\entrant\models\DocumentEducation;
use modules\entrant\models\FIOLatin;
use modules\entrant\models\InsuranceCertificateUser;
use modules\entrant\models\OtherDocument;
use modules\entrant\models\PassportData;
use olympic\models\auth\Profiles;
use yii\helpers\ArrayHelper;

class ModerationHelper
{
    const STATUS_NEW = 0;
    const STATUS_TAKE = 1;
    const STATUS_REJECT =2;
    const STATUS_REJECT_CHANGE =3;


    public static function statusList() {
        return  [
            self::STATUS_NEW => "Новый",
            self::STATUS_REJECT=> "Отклонен",
            self::STATUS_REJECT_CHANGE => "Отклонен c заменой",
            self::STATUS_TAKE => "Принят"
            ,];
    }


    public static function statusName ($key) {
        return ArrayHelper::getValue(self::statusList(), $key);
    }


    public static function modelList() {
        $models = Moderation::find()->select('model')->groupBy('model')->all();
        $data = [];

        foreach ($models as $model) {
            /** @var YiiActiveRecordAndModeration $object */
            $object = (new $model->model);
            $data[$model->model] = $object->titleModeration();

        }
        return $data;
    }

    public static function modelListForExport() {
        return [
            Profiles::class,
            PassportData::class,
            OtherDocument::class,
            DocumentEducation::class,
            FIOLatin::class,
            AdditionalInformation::class,
            AverageScopeSpo::class,
            Address::class,
            InsuranceCertificateUser::class,
        ];
    }
}