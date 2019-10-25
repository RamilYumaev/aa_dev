<?php
namespace  dictionary\helpers;

use dictionary\models\DictClass;
use yii\helpers\ArrayHelper;

class DictClassHelper
{
    /**
     * {@inheritdoc}
     */
    const SCHOOL = 1;
    const COLLEDGE = 2;
    const BACALAVR = 3;
    const MAGISTR =4;

    public static function typeOfClass()
    {
        return [
            self::SCHOOL => 'класс школы',
            self::COLLEDGE => 'курс колледжа/техникума',
            self::BACALAVR => 'курс бакалавриата',
            self::MAGISTR => 'курс магистратуры',
        ];
    }


    public static function types(): array
    {
        return [
            self::SCHOOL,
            self::COLLEDGE,
            self::BACALAVR,
            self::MAGISTR
        ];
    }

    public static function typeName($type_id): string
    {
        return ArrayHelper::getValue(self::typeOfClass(), $type_id);
    }

}