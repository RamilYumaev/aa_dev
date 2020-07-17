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
    const AGREEMENT =7;
    const MPGU_ID = 1;
    const MPGU_SR = 2;
    const MPGU_PP = 3;
    const TASHKENT_BB = 4;
    const TARGET_BB = 5;
    const TPGU = 8;
    const EXAM = 9;

    const ENTRANT_POTENTIAL_STATEMENT_DRAFT = 1;
    const ENTRANT_POTENTIAL_NO_STATEMENT = 2;
    const ENTRANT_POTENTIAL_NO_CG = 3;



    public static function listCategories()
    {
        $array = [
            self::GRADUATE =>'Аспирантура',
            self::UMS => "Управление международных связей",
            self::MPGU => "Подкомиссия",
            self::COZ => "Центр обработки заявлений",
            self::TARGET => "Работа с целевыми договорами",
            self::FOK => "Факультетская отборочная комиссия",
            self::AGREEMENT => "Договорный отдел",
            DictFacultyHelper::SERGIEV_POSAD_BRANCH => "Сергиево-Посадский филиал МПГУ (Московская область)",
            DictFacultyHelper::ANAPA_BRANCH => "Анапский филиал МПГУ (Краснодарский край)",
            DictFacultyHelper::POKROV_BRANCH => "Покровский филиал МПГУ (Владимирская область)",
            DictFacultyHelper::STAVROPOL_BRANCH => "Ставропольский филиал МПГУ (Ставропольский край)",
            DictFacultyHelper::DERBENT_BRANCH => "Дербентский филиал МПГУ (Республика Дагестан)",
            DictFacultyHelper::COLLAGE => "Колледж МПГУ",
            self::TPGU => "Совместный проект МПГУ - ТПГУ",
            self::EXAM => "Экзаменационная комиссия"
        ];

        return $array;
    }

    public static function listCategoriesFilial()
    {
        $array = [
            DictFacultyHelper::SERGIEV_POSAD_BRANCH,
            DictFacultyHelper::ANAPA_BRANCH,
            DictFacultyHelper::POKROV_BRANCH,
            DictFacultyHelper::STAVROPOL_BRANCH,
            DictFacultyHelper::DERBENT_BRANCH,
            DictFacultyHelper::COLLAGE
        ];

        return $array;
    }

    public static function listCategoriesZID()
    {
        $array = [
            DictFacultyHelper::SERGIEV_POSAD_BRANCH,
            DictFacultyHelper::ANAPA_BRANCH,
            DictFacultyHelper::POKROV_BRANCH,
            DictFacultyHelper::STAVROPOL_BRANCH,
            DictFacultyHelper::DERBENT_BRANCH,
            self::GRADUATE,
            self::MPGU];
        return $array;
    }

    public static function listCategoriesAgreement()
    {
        $array = [
            DictFacultyHelper::SERGIEV_POSAD_BRANCH,
            DictFacultyHelper::ANAPA_BRANCH,
            DictFacultyHelper::POKROV_BRANCH,
            DictFacultyHelper::STAVROPOL_BRANCH,
            DictFacultyHelper::DERBENT_BRANCH,
            DictFacultyHelper::COLLAGE,
            self::AGREEMENT,
            self::GRADUATE];
        return $array;
    }

    public static function listCategoriesZUK()
    {
        $array = [
            DictFacultyHelper::SERGIEV_POSAD_BRANCH,
            DictFacultyHelper::ANAPA_BRANCH,
            DictFacultyHelper::POKROV_BRANCH,
            DictFacultyHelper::STAVROPOL_BRANCH,
            DictFacultyHelper::DERBENT_BRANCH,
            self::GRADUATE,
            self::MPGU,
            DictFacultyHelper::COLLAGE,
            self::UMS,
            self::FOK,
            self::TPGU,
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