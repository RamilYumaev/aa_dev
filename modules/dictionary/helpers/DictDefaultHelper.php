<?php


namespace modules\dictionary\helpers;


use yii\helpers\ArrayHelper;

class DictDefaultHelper
{
    const NO = 0;
    const YES = 1;

    public static function nameList() : array
    {
        return [
            self::NO => "Нет",
            self::YES => "Да"
        ];
    }

    public static function name($key) : ?string
    {
        return ArrayHelper::getValue(self::nameList(), $key);
    }

    public static function categoryDictIAList() {
        return [
            15 => 'Аттестат о среднем (полном) общем образовании, золотая медаль',
            16 => 'Аттестат о среднем (полном) общем образовании, серебряная медаль',
            9 => 'Аттестат о среднем общем образовании с отличием',
            17 => 'Диплом о среднем профессиональном образовании с отличием',
            8 => 'Золотой знак отличия ГТО',
            13 => 'Иное',
            12 => 'Итоговое сочинение',
            10 => 'Осуществление волонтерской деятельности',
            7 => 'Победитель первенства Европы',
            6 => 'Победитель первенства мира',
            1 => 'Статус чемпиона и призера Олимпийских игр',
            2 => 'Статус чемпиона и призера Паралимпийских игр',
            3 => 'Статус чемпиона и призера Сурдлимпийских игр',
            11 => 'Участие в олимпиадах и иных конкурсах',
            5 => 'Чемпион Европы',
            4 => 'Чемпион мира'
        ];
    }

    public static function categoryExemptionList() {
        return [1 => 'инвалиды', 2 => 'сироты', 3 => 'ветераны боевых действий'];
    }

    public static function categoryExemptionName($key) : ?string
    {
        return ArrayHelper::getValue(self::categoryExemptionList(), $key);
    }

    public static function categoryDictIAName($key) : string
    {
        return ArrayHelper::getValue(self::categoryDictIAList(), $key);
    }

    public static function listInfo() {
        return [
            1=> "Яндекс" ,
            2=> "Google" ,
            3=> "Mail.ru" ,
            4=> "Официальный сайт mpgu.su" ,
            5=> "Образовательные выставки" ,
            6=> "Официальная группа университета Вконтакте" ,
            7=> "Официальная группа приемной комиссии МПГУ в Вконтакте" ,
            8=> "Социальные сети" ,
            9=> "Контекстная реклама" ,
            10=> "Родители" ,
            11=> "СМИ" ,
            12=> "Мероприятия университета (Педагогические субботы)" ,
            13=> "Выставки (ММСО, Образование и карьера)" ,
            14=> "Дни открытых дверей" ,
            15=> "Учителя" ,
            16=> "Друзья" ,
            17=> "По рекомендации друга" ,
            18=>  'Сайт "Учеба.ру"' ,
            19=> "Бывший студент МПГУ",
            20=> "Иной источник"
        ];
    }

    public static function infoName($key) : string
    {
        return ArrayHelper::getValue(self::listInfo(), $key);
    }

}