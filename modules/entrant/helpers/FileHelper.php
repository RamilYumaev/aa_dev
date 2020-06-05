<?php


namespace modules\entrant\helpers;


use modules\entrant\models\Address;
use modules\entrant\models\Agreement;
use modules\entrant\models\DocumentEducation;
use modules\entrant\models\OtherDocument;
use modules\entrant\models\PassportData;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementCg;
use modules\entrant\models\StatementConsentCg;
use modules\entrant\models\StatementConsentPersonalData;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\models\StatementRejection;
use modules\entrant\models\StatementRejectionCgConsent;
use Yii;

class FileHelper
{

    const STATUS_DRAFT = 0;
    const STATUS_WALT  = 1;
    const STATUS_ACCEPTED = 2;
    const STATUS_NO_ACCEPTED = 3;

    public static function statusList() {
        return[
            self::STATUS_DRAFT =>"Новый",
            self::STATUS_WALT=> "Ожидание",
            self::STATUS_ACCEPTED =>"Принято",
            self::STATUS_NO_ACCEPTED =>"Не принято",];
    }

    public static function statusName($key) {
        return self::statusList()[$key];
    }

    public static function colorList() {
        return [
            self::STATUS_DRAFT =>"default",
            self::STATUS_WALT=> "warning",
            self::STATUS_ACCEPTED =>"success",
            self::STATUS_NO_ACCEPTED =>"danger",
            ];
    }

    public static function colorName($key) {
        return self::colorList()[$key];
    }
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
            StatementConsentCg::class,
            StatementCg::class,
            StatementRejection::class,
            StatementRejectionCgConsent::class
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
            StatementRejection::class => 0,
            StatementRejectionCgConsent::class =>0,
            StatementCg::class =>0,
        ];
    }

}