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
    const SCHOOL_LAST = 5;
    const COLLEDGE_LAST = 6;
    const BACALAVR_LAST = 7;
    const MAGISTR_LAST = 8;
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
            self::SCHOOL_LAST => 'выпускной класс школы',
            self::COLLEDGE_LAST => 'выпускной курс колледжа/техникума',
            self::BACALAVR_LAST=> 'выпускной курс бакалавриата',
            self::MAGISTR_LAST => 'выпускной курс магистратуры',
            self::GRADUATED_SCHOOL => 'закончил(а) школу или лицей',
            self::GRADUATED_COLLEGE => 'закончил(а) колледж или техникум',
            self::GRADUATED_BACALAVR => 'закончил(а) бакалавриат',
            self::GRADUATED_SPECIALIST => 'закончил(а) специалитет',
            self::GRADUATED_MAGISTR => 'закончил(а) магистратуру',
            self::GRADUATED_ASPIRANTURA => 'закончил(а) аспирантуру',
            self::GRADUATED_DOCTORANTURA => 'закончил(а) докторантуру',

        ];
    }

    public static function typeOfClassMany()
    {
        return [
            self::SCHOOL => 'класс(ы) школы',
            self::COLLEDGE => 'курс(ы) колледжа/техникума',
            self::BACALAVR => 'курс(ы) бакалавриата',
            self::MAGISTR => 'курс(ы) магистратуры',
            self::SCHOOL_LAST => 'выпускной(ые) класс(ы) школы',
            self::COLLEDGE_LAST => 'выпускной(ые) курс(ы) колледжа/техникума',
            self::BACALAVR_LAST=> 'выпускной(ые) курс(ы) бакалавриата',
            self::MAGISTR_LAST => 'выпускной(ые) курс(ы) магистратуры',
            self::GRADUATED_SCHOOL => 'закончил(а) школу или лицей',
            self::GRADUATED_COLLEGE => 'закончил(а) колледж или техникум',
            self::GRADUATED_BACALAVR => 'закончил(а) бакалавриат',
            self::GRADUATED_SPECIALIST => 'закончил(а) специалитет',
            self::GRADUATED_MAGISTR => 'закончил(а) магистратуру',
            self::GRADUATED_ASPIRANTURA => 'закончил(а) аспирантуру',
            self::GRADUATED_DOCTORANTURA => 'закончил(а) докторантуру',
        ];
    }

    public static function typeOfClassManyGenitive()
    {
        return [
            self::SCHOOL => 'класса(ов) школы',
            self::COLLEDGE => 'курса(ов) колледжа/техникума',
            self::BACALAVR => 'курса(ов) бакалавриата',
            self::MAGISTR => 'курса(ов) магистратуры',
            self::SCHOOL_LAST => 'выпускного(ых) класса(ов) школы',
            self::COLLEDGE_LAST => 'выпускного(ых) курса(ов) колледжа/техникума',
            self::BACALAVR_LAST=> 'выпускного(ых) курса(ов) бакалавриата',
            self::MAGISTR_LAST => 'выпускного(ых) курса(ов) магистратуры',
            self::GRADUATED_SCHOOL => 'выпускники школ',
            self::GRADUATED_COLLEGE => 'выпускники колледжей и техникумов',
            self::GRADUATED_BACALAVR => 'выпускники бакалавриата',
            self::GRADUATED_SPECIALIST => 'выпускники специалитета',
            self::GRADUATED_MAGISTR => ' выпускники магистратуры',
            self::GRADUATED_ASPIRANTURA => 'выпускники аспирантуры',
            self::GRADUATED_DOCTORANTURA => 'выпускники докторантуры',
        ];
    }


    public static function types(): array
    {
        return [
            self::SCHOOL,
            self::COLLEDGE,
            self::BACALAVR,
            self::MAGISTR,
            self::SCHOOL_LAST,
            self::COLLEDGE_LAST,
            self::BACALAVR_LAST,
            self::MAGISTR_LAST,
            self::GRADUATED_SCHOOL,
            self::GRADUATED_COLLEGE,
            self::GRADUATED_BACALAVR,
            self::GRADUATED_SPECIALIST,
            self::GRADUATED_MAGISTR,
            self::GRADUATED_ASPIRANTURA,
            self::GRADUATED_DOCTORANTURA,
        ];
    }

    public static function typesGraduated(): array
    {
        return [
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
        return ArrayHelper::getValue(self::typeOfClassManyGenitive(), $type_id);
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

    public static function getList()
    {
        $classes = \dictionary\models\DictClass::find()->orderBy("id")->all();
        $result = [];
        foreach ($classes as $class) {
            $result[$class->id] = $class->getClassFullName();
        }

        return $result;

    }

    public static function getListMPSU()
    {
        $classes = \dictionary\models\DictClass::find()->andWhere(['type' =>[self::BACALAVR,  self::MAGISTR ]])->orderBy("id")->all();
        $result = [];
        foreach ($classes as $class) {
            $result[$class->id] = $class->getClassFullName();
        }

        return $result;

    }

}