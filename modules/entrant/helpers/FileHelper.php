<?php


namespace modules\entrant\helpers;


use modules\entrant\models\Address;
use modules\entrant\models\Agreement;
use modules\entrant\models\DocumentEducation;
use modules\entrant\models\OtherDocument;
use modules\entrant\models\PassportData;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementConsentCg;
use modules\entrant\models\StatementConsentPersonalData;
use modules\entrant\models\StatementIndividualAchievements;
use Yii;

class FileHelper
{
    public static function listModels() {
        return [
            Statement::class,
            DocumentEducation::class,
            PassportData::class,
            Address::class,
            OtherDocument::class,
            Agreement::class,
            StatementIndividualAchievements::class,
            StatementConsentPersonalData::class,
            StatementConsentCg::class
        ];
    }

    public static function validateModel($hash){
        foreach(self::listModels() as  $model) {
          if(Yii::$app->getSecurity()->decryptByKey($hash, $model)) {
              return $model;
          }
        }
        return null;
    }

    public static function listCountModels() {
        return [
            DocumentEducation::class => 10,
            PassportData::class => 1,
            Address::class => 1,
            OtherDocument::class => 20,
            Agreement::class => 20,
            StatementIndividualAchievements::class => 0,
            Statement::class => 0,
            StatementConsentPersonalData::class => 0,
            StatementConsentCg::class => 0,
        ];
    }

}