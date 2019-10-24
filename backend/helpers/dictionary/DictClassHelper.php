<?php

namespace backend\helpers\dictionary;

use backend\models\dictionary\DictClass;
use yii\helpers\ArrayHelper;

class DictClassHelper
{
    public static function typeOfClass()
    {
        return [
            DictClass::SCHOOL => 'класс школы',
            DictClass::COLLEDGE => 'курс колледжа/техникума',
            DictClass::BACALAVR => 'курс бакалавриата',
            DictClass::MAGISTR => 'курс магистратуры',
        ];
    }


    public static function types(): array
    {
        return [
            DictClass::SCHOOL,
            DictClass::COLLEDGE,
            DictClass::BACALAVR,
            DictClass::MAGISTR
        ];
    }

    public static function typeName($type_id): string
    {
        return ArrayHelper::getValue(self::typeOfClass(), $type_id);
    }

}