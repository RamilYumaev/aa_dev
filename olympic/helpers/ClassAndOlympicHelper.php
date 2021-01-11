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

    public static function olympicClassLists($id) {
        return ArrayHelper::map(DictClassHelper::dictClassAll(self::olympicClassList($id)),
            "id", function (array $model) {
            return $model['name'] . "-й ". DictClassHelper::typeName($model['type']);
        });
    }

    public static function olympicClassString($id) {
        $classesOlympic = DictClassHelper::dictClassAll(self::olympicClassList($id));
        $typeClassOlympic = DictClassHelper::dictClassTypeAll(self::olympicClassList($id));

        $result = "";
        foreach ($typeClassOlympic as $type) {
            if (!in_array($type, DictClassHelper::typesGraduated())){
                foreach ($classesOlympic as $class) {
                    if ($class['type'] == $type) {
                        $result .= $class['name'] . ", ";
                    }
                }
            $result = rtrim($result, ", ") . " ";
            $result .= DictClassHelper::typeManyName($type) . ", ";
            }
        }

        return $result ? "обучающиеся ". rtrim ($result, ", ") : "";
    }

    public static function olympicClassGraduateString($id) {

        $typeClassOlympic = DictClassHelper::dictClassTypeAll(self::olympicClassList($id));
        $result = "";
        $array =DictClassHelper::typesGraduated();
        $i = 0;
        foreach ($typeClassOlympic as $type) {
            if (in_array($type, $array)){
                $result .= DictClassHelper::typeManyName($type) . ", ";
                if (in_array($type, $array) && ($type != DictClassHelper::GRADUATED_SCHOOL || $type != DictClassHelper::GRADUATED_COLLEGE)) {
                    $i++;
                }
                if ($i == 5) {
                    return "выпускники организаций высшего образования";
                }
            }
        }

        return rtrim ($result, ", ");
    }


}