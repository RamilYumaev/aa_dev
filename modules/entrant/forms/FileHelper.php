<?php


namespace modules\entrant\forms;


use modules\entrant\models\DocumentEducation;
use modules\entrant\models\Statement;
use Yii;

class FileHelper
{
    public static function listModels() {
        return [
            Statement::class,
            DocumentEducation::class,
        ];
    }

    public static function validateModel($hash){
        foreach(self::listModels() as  $model) {
          if(Yii::$app->security->validatePassword($model,$hash)) {
              return $model;
          }
        }
        return null;
    }

}