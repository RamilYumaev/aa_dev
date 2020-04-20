<?php

namespace modules\entrant\helpers;


use dictionary\helpers\DictCompetitiveGroupHelper;
use yii\helpers\Html;

class AnketaHelper
{
    const SCHOOL_TYPE_SCHOOL = 1;
    const SCHOOL_TYPE_SPO = 2;
    const SCHOOL_TYPE_BACHELOR = 3;
    const SCHOOL_TYPE_SPECIALIST = 4;
    const SCHOOL_TYPE_MAGISTER = 5;
    const SCHOOL_TYPE_DIPLOMA_SPECIALIST = 6;
    const SCHOOL_TYPE_PHD = 7;
    const SCHOOL_TYPE_DOCTOR_SCIENCES = 8;
    const SCHOOL_TYPE_NPO = 9;
    const SCHOOL_TYPE_SCHOOL_9 = 10;


    const SPO_LEVEL = [
        self::SCHOOL_TYPE_SCHOOL_9,
        self::SCHOOL_TYPE_SCHOOL
    ];
    const SPO_LEVEL_ONLY_CONTRACT = [
        self::SCHOOL_TYPE_NPO,
        self::SCHOOL_TYPE_SPO,
        self::SCHOOL_TYPE_SCHOOL,
        self::SCHOOL_TYPE_BACHELOR,
        self::SCHOOL_TYPE_MAGISTER,
        self::SCHOOL_TYPE_DIPLOMA_SPECIALIST,
        self::SCHOOL_TYPE_SPECIALIST,
        self::SCHOOL_TYPE_DOCTOR_SCIENCES,
        self::SCHOOL_TYPE_PHD

    ];
    const BACHELOR_LEVEL = [
        self::SCHOOL_TYPE_SCHOOL,
        self::SCHOOL_TYPE_SPO,
        self::SCHOOL_TYPE_NPO,
    ];
    const BACHELOR_LEVEL_ONLY_CONTRACT = [
        self::SCHOOL_TYPE_BACHELOR,
        self::SCHOOL_TYPE_DIPLOMA_SPECIALIST,
        self::SCHOOL_TYPE_MAGISTER,
        self::SCHOOL_TYPE_SPECIALIST,
        self::SCHOOL_TYPE_PHD,
        self::SCHOOL_TYPE_DOCTOR_SCIENCES
    ];
    const MAGISTRACY_LEVEL = [
        AnketaHelper::SCHOOL_TYPE_BACHELOR,
        AnketaHelper::SCHOOL_TYPE_DIPLOMA_SPECIALIST
    ];
    const MAGISTRACY_LEVEL_ONLY_CONTRACT = [
        AnketaHelper::SCHOOL_TYPE_MAGISTER,
        AnketaHelper::SCHOOL_TYPE_SPECIALIST,
        AnketaHelper::SCHOOL_TYPE_PHD,
        AnketaHelper::SCHOOL_TYPE_DOCTOR_SCIENCES
    ];
    const HIGH_GRADUATE_LEVEL = [
        AnketaHelper::SCHOOL_TYPE_MAGISTER,
        AnketaHelper::SCHOOL_TYPE_SPECIALIST,
        AnketaHelper::SCHOOL_TYPE_DIPLOMA_SPECIALIST,
    ];
    const HIGH_GRADUATE_LEVEL_ONLY_CONTRACT = [
        AnketaHelper::SCHOOL_TYPE_PHD,
        AnketaHelper::SCHOOL_TYPE_DOCTOR_SCIENCES
    ];

    const ONLY_PAY_CONDITION = 1;
    const FULL_CONDITION = 2;


    public static function currentEducationLevel()
    {
        return [
            self::SCHOOL_TYPE_SCHOOL_9 => 'Основное общее образование (Аттестат за 9 классов)',
            self::SCHOOL_TYPE_SCHOOL => 'Среднее общее образование (Аттестат за 11 классов)',
            self::SCHOOL_TYPE_NPO => 'Начальное профессиональное образование (Диплом НПО)',
            self::SCHOOL_TYPE_SPO => 'Среднее профессиональное образование (Диплом СПО)',
            self::SCHOOL_TYPE_BACHELOR => 'Бакалавриат (Диплом бакалавра)',
            self::SCHOOL_TYPE_SPECIALIST => 'Высшее образование (Диплом специалиста)*',
            self::SCHOOL_TYPE_MAGISTER => 'Высшее образование (Диплом магистра)',
            self::SCHOOL_TYPE_DIPLOMA_SPECIALIST => 'Высшее образование (Дипломированный специалист)',
            self::SCHOOL_TYPE_PHD => 'Высшее образование (Диплом кандидата наук или аспиранта)',
            self::SCHOOL_TYPE_DOCTOR_SCIENCES => 'Высшее образование (Диплом доктора наук)',
        ];
    }


    public static function getButton($level, $specialRight = null)
    {
        if ($specialRight == DictCompetitiveGroupHelper::TARGET_PLACE) {
            $anchor = "Выбрать целевые программы";
        } elseif ($specialRight == DictCompetitiveGroupHelper::SPECIAL_RIGHT) {
            $anchor = "Выбрать программы для льготных категории";

        }else{
            $anchor = "Выбрать программы";
        }

        return Html::a($anchor, ["applications/"
            . DictCompetitiveGroupHelper::getUrl($level)],
            ["class" => "btn btn-warning"]);
    }

}