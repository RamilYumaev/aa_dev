<?php

namespace olympic\helpers;

use dictionary\helpers\DictClassHelper;
use dictionary\models\DictClass;
use olympic\models\ClassAndOlympic;
use yii\helpers\ArrayHelper;

class ClassAndOlympicHelper
{
    public static function olympicClassList($id) {
        return ClassAndOlympic::find()->select('class_id')->andWhere(['olympic_id'=> $id])->column();
    }

    public static function olympicClassRegisterList($id) {
        return ArrayHelper::map(DictClass::find()->where(['in', 'id', self::olympicClassList($id)])->asArray()->all(),
            "id", function (array $model) {
            return $model['name'] . "-й ". DictClassHelper::typeName($model['type']);
        });
    }

}