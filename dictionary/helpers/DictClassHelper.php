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
    const GRADUATED_SCHOOL = 10;
    const GRADUATED_COLLEGE = 20;
    const GRADUATED_BACALAVR = 30;
    const GRADUATED_SPECIALIST = 35;
    const GRADUATED_MAGISTR = 50;
    const GRADUATED_ASPIRANTURA = 60;
    const GRADUATED_DOCTORANTURA = 70;

    public static function typeOfClass()
    {
        return [
            self::SCHOOL => 'класс школы',
            self::COLLEDGE => 'курс колледжа/техникума',
            self::BACALAVR => 'курс бакалавриата',
            self::MAGISTR => 'курс магистратуры',
            self::GRADUATED_SCHOOL => 'закончил(а) школу или лицей',
            self::GRADUATED_COLLEGE => 'закончил(а) колледж или техникум',
            self::GRADUATED_BACALAVR => 'закончил(а) бакалавриат',
            self::GRADUATED_SPECIALIST => 'закончил(а) специалитет',
            self::GRADUATED_MAGISTR => 'закончила(а) магистратуру',
            self::GRADUATED_ASPIRANTURA => 'закончила(а) аспирантуру',
            self::GRADUATED_DOCTORANTURA => 'закончила(а) докторантуру',

        ];
    }

    public static function typeOfClassMany()
    {
        return [
            self::SCHOOL => 'класс(ы) школы',
            self::COLLEDGE => 'курс(ы) колледжа/техникума',
            self::BACALAVR => 'курс(ы) бакалавриата',
            self::MAGISTR => 'курс(ы) магистратуры',
            self::GRADUATED_SCHOOL => 'закончил(а) школу или лицей',
            self::GRADUATED_COLLEGE => 'закончил(а) колледж или техникум',
            self::GRADUATED_BACALAVR => 'закончил(а) бакалавриат',
            self::GRADUATED_SPECIALIST => 'закончил(а) специалитет',
            self::GRADUATED_MAGISTR => 'закончил(а) магистратуру',
            self::GRADUATED_ASPIRANTURA => 'закончил(а) аспирантуру',
            self::GRADUATED_DOCTORANTURA => 'закончил(а) докторантуру',
        ];
    }


    public static function types(): array
    {
        return [
            self::SCHOOL,
            self::COLLEDGE,
            self::BACALAVR,
            self::MAGISTR,
            self::GRADUATED_SCHOOL,
            self::GRADUATED_COLLEGE,
            self::GRADUATED_BACALAVR,
            self::GRADUATED_SPECIALIST,
            self::GRADUATED_MAGISTR,
            self::GRADUATED_ASPIRANTURA,
            self::GRADUATED_DOCTORANTURA,
        ];
    }

    public static function typeName($type_id): ? string
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

    public static function classFullName($key): ?string
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