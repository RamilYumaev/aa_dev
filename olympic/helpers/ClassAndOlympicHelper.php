<?php

namespace olympic\helpers;

use olympic\models\ClassAndOlympic;

class ClassAndOlympicHelper
{
    public static function olympicClassList($id) {
        return ClassAndOlympic::find()->select('class_id')->andWhere(['olympic_id'=> $id])->column();
    }

}