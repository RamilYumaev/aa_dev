<?php


namespace modules\dictionary\helpers;


use dictionary\helpers\DictFacultyHelper;
use modules\dictionary\models\JobEntrant;
use yii\helpers\ArrayHelper;
use yii\queue\closure\Job;

class JobEntrantHelper
{

    const DRAFT = 0;
    const ACTIVE =1;
    const TARGET = 1;
    const MPGU = 2;
    const FOK =3;
    const GRADUATE =4;
    const UMS =5;
    const COZ =6;

    public static function listCategories()
    {
        $array = [
            self::GRADUATE =>'Аспирантура',
            self::UMS => "Управление международных связей",
            self::MPGU => "Подкомиссия",
            self::COZ => "Центр обработки заявлений",
            self::TARGET => "Работа с целевыми договорами",
            self::FOK => "Факультетская отборочная комиссия",
            DictFacultyHelper::SERGIEV_POSAD_BRANCH => "Сергиево-Посадский филиал МПГУ (Московская область)",
            DictFacultyHelper::ANAPA_BRANCH => "Анапский филиал МПГУ (Краснодарский край)",
            DictFacultyHelper::POKROV_BRANCH => "Покровский филиал МПГУ (Владимирская область)",
            DictFacultyHelper::STAVROPOL_BRANCH => "Ставропольский филиал МПГУ (Ставропольский край)",
            DictFacultyHelper::DERBENT_BRANCH => "Дербентский филиал МПГУ (Республика Дагестан)",
            DictFacultyHelper::COLLAGE => "Колледж МПГУ"
        ];

        return $array;
    }

    public static function statusList()
    {
        return [
            self::ACTIVE => 'Активный',
            self::DRAFT => 'Неактивный',
        ];
    }

    public static function columnJobEntrant($column, $value) {
        return ArrayHelper::map(JobEntrant::find()->select($column)->groupBy($column)->all(), $column, $value);
    }



}