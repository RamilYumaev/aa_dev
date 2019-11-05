<?php

namespace olympic\helpers;

use dictionary\helpers\DictClassHelper;
use dictionary\models\DictClass;
use olympic\models\ClassAndOlympic;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;

class ClassAndOlympicHelper
{
    public static function olympicClassList($id) {
        return ClassAndOlympic::find()->select('class_id')->andWhere(['olympic_id'=> $id])->column();
    }

    public static function olympicClassRegisterList($id) {
        return ArrayHelper::map(self::dictClassAll($id),
            "id", function (array $model) {
            return $model['name'] . "-й ". DictClassHelper::typeName($model['type']);
        });
    }

    public static function olympicClassString($id) {
        $classesOlympic = self::dictClassAll($id);
        $typeClassOlympic = self::dictClassTypeAll($id);

        $result = "";
        foreach ($typeClassOlympic as $type) {
            foreach($classesOlympic as $class) {
                if ($class['type'] == $type) {
                    $result .= $class['name']. ", ";
                }
            }
            $result = rtrim($result, ", "). " ";
            $result .= DictClassHelper::typeManyName($type).", ";
        }

        return rtrim ($result, ", ");
    }

    protected static function dictClassAll($id) {

        return DictClass::find()->where(['in', 'id', self::olympicClassList($id)])->orderBy(['id' => SORT_ASC])->asArray()->all();
    }

    protected static function dictClassTypeAll($id) {

        return DictClass::find()->select('type')->where(['in', 'id', self::olympicClassList($id)])->indexBy('type')->column();
    }

}