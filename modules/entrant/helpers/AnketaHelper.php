<?php

namespace modules\entrant\helpers;


use common\components\JsonAjaxField;
use common\helpers\EduYearHelper;
use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\dictionary\models\SettingEntrant;
use modules\entrant\models\Agreement;
use modules\entrant\models\Anketa;
use modules\entrant\models\OtherDocument;
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
        self::SCHOOL_TYPE_NPO,
    ];
    const SPO_LEVEL_ONLY_CONTRACT = [
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

    const HEAD_UNIVERSITY = 1;
    const ANAPA_BRANCH = 21; //@TODO нужно будет отвязать от справочника
    const POKROV_BRANCH = 24; //@TODO нужно будет отвязать от справочника
    const STAVROPOL_BRANCH = 23; //@TODO нужно будет отвязать от справочника
    const DERBENT_BRANCH = 22; //@TODO нужно будет отвязать от справочника
    const SERGIEV_POSAD_BRANCH = 40; //@TODO нужно будет отвязать от справочника

    const ONLY_PAY_CONDITION = 1;
    const FULL_CONDITION = 2;

    public static function universityChoice()
    {
        return [
            self::HEAD_UNIVERSITY => "В головной вуз или колледж МПГУ (г. Москва)",
            self::SERGIEV_POSAD_BRANCH => "В Сергиево-Посадский филиал МПГУ (Московская область)",
            self::ANAPA_BRANCH => "В Анапский филиал МПГУ (Краснодарский край)",
            self::POKROV_BRANCH => "В Покровский филиал МПГУ (Владимирская область)",
            self::STAVROPOL_BRANCH => "В Ставропольский филиал МПГУ (Ставропольский край)",
            self::DERBENT_BRANCH => "В Дербентский филиал МПГУ (Республика Дагестан)",

        ];
    }

    public static function educationLevelSpecialRight()
    {
        return [
            self::SCHOOL_TYPE_SCHOOL,
            self::SCHOOL_TYPE_NPO,
            self::SCHOOL_TYPE_SPO,
        ];
    }


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

    public static function educationLevelChoice($universityChoice)
    {
        $arrayKey = [
            self::SCHOOL_TYPE_SCHOOL_9,
            self::SCHOOL_TYPE_SCHOOL,
            self::SCHOOL_TYPE_NPO,
            self::SCHOOL_TYPE_SPO,
            self::SCHOOL_TYPE_BACHELOR,
            self::SCHOOL_TYPE_SPECIALIST,
            self::SCHOOL_TYPE_MAGISTER,
            self::SCHOOL_TYPE_DIPLOMA_SPECIALIST,
            self::SCHOOL_TYPE_PHD,
            self::SCHOOL_TYPE_DOCTOR_SCIENCES,
        ];
        if ($universityChoice == self::DERBENT_BRANCH
            || $universityChoice == self::SERGIEV_POSAD_BRANCH
            || $universityChoice == self::POKROV_BRANCH) {
            unset($arrayKey[0]);
        }

        return JsonAjaxField::data($arrayKey, self::currentEducationLevel());
    }

    public static function dataArray($userId)
    {
        return Anketa::findOne(['user_id' => $userId])->dataArray();
    }

    public static function getButton($level, $department, $specialRight = null, $govLineStatus = false, $tpguStatus = false)
    {

        if ($specialRight == DictCompetitiveGroupHelper::TARGET_PLACE) {
            $anchor = "Целевое обучение";
        } elseif ($specialRight == DictCompetitiveGroupHelper::SPECIAL_RIGHT) {
            $anchor = "Особая квота";
        } else {
            $anchor = "Общий конкурс";
        }

        return Html::a($anchor, ["applications/"
            . DictCompetitiveGroupHelper::getUrlString($level, $specialRight, $govLineStatus, $tpguStatus), 'department'=> $department],
            ["class" => "btn btn-lg btn-bd-primary"]);
    }

    public static function determinateRequiredNumberOfButtons($level, $department, $showUsual = true)
    {
        $buttonArray = [];
        $anketa = \Yii::$app->user->identity->anketa();
        $arrayEduLevel = self::getPermittedEducationLevels($level);

        if ($level !== DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO
            && in_array($anketa->current_edu_level, $arrayEduLevel) && $anketa->category_id == CategoryStruct::GENERAL_COMPETITION) {
            $buttonArray[] = DictCompetitiveGroupHelper::TARGET_PLACE;
        }
        if ($level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR && $anketa->category_id == CategoryStruct::GENERAL_COMPETITION) {
            $buttonArray[] = DictCompetitiveGroupHelper::SPECIAL_RIGHT;
        }

        $govLineStatus = false;
        $tpguStatus = false;
        if ($anketa->category_id == CategoryStruct::GOV_LINE_COMPETITION) {
            $govLineStatus = true;
        }

        if($anketa->category_id == CategoryStruct::TPGU_PROJECT){
            $tpguStatus = true;
        }

        $result = "";
        if (count($buttonArray)) {
            foreach ($buttonArray as $button) {
                if(!SettingEntrant::find()->isOpenZukApplication($department, $level,  $button, $tpguStatus,  $govLineStatus))  {
                    continue;
                }
                $result .= self::getButton($level, $department, $button, $tpguStatus,  $govLineStatus) . "<br/>";
            }
        }
        if ($showUsual) {
            $result .= self::getButton($level, $department, null, $govLineStatus,  $tpguStatus);
        }

        return $result;
    }

    public static function getPermittedEducationLevels($level): array
    {

        switch ($level){
            case DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO :
                return [];
            case DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR :
                return self::BACHELOR_LEVEL;
            case DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER :
                return self::MAGISTRACY_LEVEL;
            case DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL :
                return self::HIGH_GRADUATE_LEVEL;
            default :
                throw new \DomainException("Неправильно определен уровень образования");
        }
    }
}