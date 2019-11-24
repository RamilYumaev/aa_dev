<?php

namespace dictionary\helpers;

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
    const MAGISTR = 4;

    public static function typeOfClass()
    {
        return [
            self::SCHOOL => 'класс школы',
            self::COLLEDGE => 'курс колледжа/техникума',
            self::BACALAVR => 'курс бакалавриата',
            self::MAGISTR => 'курс магистратуры',
        ];
    }

    public static function typeOfClassMany()
    {
        return [
            self::SCHOOL => 'класс(ы) школы',
            self::COLLEDGE => 'курс(ы) колледжа/техникума',
            self::BACALAVR => 'курс(ы) бакалавриата',
            self::MAGISTR => 'курс(ы) магистратуры',
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

    public static function typeManyName($type_id): string
    {
        return ArrayHelper::getValue(self::typeOfClassMany(), $type_id);
    }

    public static function classFullNameList(): array
    {
        return ArrayHelper::map(DictClass::find()->asArray()->all(), "id", function (array $model) {
            return $model['name'] . "-й ". self::typeName($model['type']);
        });
    }

    public static function classFullName($key): string
    {
        return ArrayHelper::getValue(self::classFullNameList(), $key);
    }

    public static function dictClassAll($classList) {

        return DictClass::find()->where(['in', 'id', $classList])->orderBy(['id' => SORT_ASC])->asArray()->all();
    }

    public static function dictClassTypeAll($classList) {

        return DictClass::find()->select('type')->where(['in', 'id', $classList])->indexBy('type')->column();
    }

}