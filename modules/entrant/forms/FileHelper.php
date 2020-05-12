<?php


namespace modules\entrant\forms;


use modules\entrant\models\Address;
use modules\entrant\models\Agreement;
use modules\entrant\models\DocumentEducation;
use modules\entrant\models\OtherDocument;
use modules\entrant\models\PassportData;
use modules\entrant\models\Statement;
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
            StatementIndividualAchievements::class
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

}