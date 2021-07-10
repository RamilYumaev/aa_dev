<?php


namespace modules\entrant\helpers;

use modules\entrant\models\DocumentEducation;
use modules\entrant\models\OtherDocument;
use modules\entrant\models\PassportData;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementConsentCg;
use yii\helpers\ArrayHelper;

class AisReturnDataHelper
{
    const AIS_YES = 1;
    const AIS_NO = 2;
    const IN_WORK = 3;
    const IN_EPGU = 4;
    const IN_TIME = 5;
    public static  function typesModel() {
        return [
          1 => PassportData::class,
          2 => OtherDocument::class,
          3 => DocumentEducation::class,
            4 => Statement::class,
            5 => StatementConsentCg::class
        ];
    }

    public static function modelKey($key){
       return ArrayHelper::getValue(self::typesModel(), $key);
    }

    public static function status() {
        return[
            self::AIS_YES =>"Принятые",
            self::AIS_NO =>"Необработанные",
            self::IN_WORK => "Взяты в работу",
            self::IN_EPGU => "ЕПГУ",
            self::IN_TIME => "Очный прием"
            ];
    }

    public static function statusName($key) {
        return self::status()[$key];
    }
}