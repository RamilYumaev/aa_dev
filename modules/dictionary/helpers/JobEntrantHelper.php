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

    const VOLUNTEERING  = 0;
    const TARGET = 1;
    const MPGU = 2;
    const FOK =3;
    const GRADUATE =4;
    const UMS =5;
    const COZ =6;
    const AGREEMENT =7;
    const TPGU = 8;
    const EXAM = 9;
    const CALL = 10;
    const INFORMATION = 11;
    const REGISTRATION  = 12;
    const PROCTORING =13;
    const MAIL = 14;
    const TRANSFER =15;

    const MPGU_ID = 1;
    const MPGU_SR = 2;
    const MPGU_PP = 3;
    const TASHKENT_BB = 4;
    const TARGET_BB = 5;
    const SPECIAL_QUOTA = 6;

    const ENTRANT_POTENTIAL_STATEMENT_DRAFT = 1;
    const ENTRANT_POTENTIAL_NO_STATEMENT = 2;
    const ENTRANT_POTENTIAL_NO_CG = 3;


    public static function listCategories()
    {
        $array = [
            self::VOLUNTEERING => "Волонтерство",
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
            DictFacultyHelper::CHERNOHOVSK_BRANCH => "Филиал МПГУ в г. Черняховске",
            DictFacultyHelper::COLLAGE => "Колледж МПГУ",
            self::TPGU => "Совместный проект МПГУ - ТПГУ",
            self::EXAM => "Экзаменационная комиссия",
            self::TRANSFER => 'Переводы и восстановления. Подразделение'
        ];
        return $array;
    }

    public static function listVolunteeringCategories()
    {
        $array = [
            self::CALL => "Call-центр",
            self::INFORMATION => "Центр информации",
            self::REGISTRATION =>"Центр регистрации",
            self::PROCTORING => "Центр прокторинга",
            self::COZ => "Центр обработки заявлений",
            self::MAIL => "Почта",
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
            DictFacultyHelper::CHERNOHOVSK_BRANCH,
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
            DictFacultyHelper::CHERNOHOVSK_BRANCH,
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
            DictFacultyHelper::CHERNOHOVSK_BRANCH,
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
            DictFacultyHelper::CHERNOHOVSK_BRANCH,
            self::GRADUATE,
            self::MPGU,
            DictFacultyHelper::COLLAGE,
            self::UMS,
            self::FOK,
            self::TPGU,
            self::TARGET
        ];
        return $array;
    }

    public static function listCategoriesCoz()
    {
        $array = [
            DictFacultyHelper::SERGIEV_POSAD_BRANCH,
            DictFacultyHelper::ANAPA_BRANCH,
            DictFacultyHelper::POKROV_BRANCH,
            DictFacultyHelper::STAVROPOL_BRANCH,
            DictFacultyHelper::DERBENT_BRANCH,
            DictFacultyHelper::CHERNOHOVSK_BRANCH,
            self::GRADUATE,
            DictFacultyHelper::COLLAGE,
            self::FOK
        ];
        return $array;
    }

    public static function isProctor()
    {
        $array = [
            self::COZ,
            self::VOLUNTEERING,
            self::TARGET,
            self::FOK
        ];
        return $array;
    }

    public static function isExamRight()
    {
        $array = [
            self::COZ,
            self::EXAM
        ];
        return $array;
    }

    public static function isTransfer()
    {
        $array = [
            self::AGREEMENT,
            self::TRANSFER
        ];
        return $array;
    }

    public static function isIPZ()
    {
        $array = [
            self::COZ,
            self::MPGU,
            self::TARGET,
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

    public static function postList()
    {
        return [
            null => 'Нет должности',
            1 => 'Ответственный секретарь отборочной комиссии',
            2 => 'Технический секретарь отборочной комиссиий',
        ];
    }

    public static function columnJobEntrant($column, $value) {
        return ArrayHelper::map(JobEntrant::find()->select($column)->groupBy($column)->all(), $column, $value);
    }
}