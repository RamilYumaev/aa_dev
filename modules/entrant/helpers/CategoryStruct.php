<?php
namespace modules\entrant\helpers;

use common\components\JsonAjaxField;

class CategoryStruct
{
    const GENERAL_COMPETITION = 1;
    const WITHOUT_COMPETITION = 2;
    const TARGET_COMPETITION = 3;
    const SPECIAL_RIGHT_COMPETITION = 4;
    const GOV_LINE_COMPETITION = 5;
    const FOREIGNER_CONTRACT_COMPETITION = 6;
    const COMPATRIOT_COMPETITION = 7;
    const TPGU_PROJECT = 8;


    public static function labelLists()
    {
        return [
            self::GENERAL_COMPETITION => "Поступающий на общих основаниях",
            self::WITHOUT_COMPETITION => "Победители или призёры олимпиад/соревнований, имеющие особые права и преимущества (100 баллов/БВИ)",
            self::TARGET_COMPETITION => "Поступащий на целевое обучение",
            self::SPECIAL_RIGHT_COMPETITION => "Поступающий на особую квоту",
            self::GOV_LINE_COMPETITION => "Иностранный гражданин, поступающий по гослинии",
            self::FOREIGNER_CONTRACT_COMPETITION => "Иностранный гражданин, поступающий на платной основе",
            self::COMPATRIOT_COMPETITION => "Соотечественник",
            self::TPGU_PROJECT => "Совместный образовательный проект МПГУ - ТГПУ (респ. Узбекистан)",
        ];
    }

    public static function UMSGroup()
    {
        return [
            self::FOREIGNER_CONTRACT_COMPETITION,
            self::GOV_LINE_COMPETITION,

        ];
    }

    public static function foreignerGroup()
    {
        return [
            self::COMPATRIOT_COMPETITION,
            self::FOREIGNER_CONTRACT_COMPETITION,
            self::GOV_LINE_COMPETITION,
            self::TPGU_PROJECT,
        ];
    }

    public static function CPKGroup()
    {
        return [
            self::GENERAL_COMPETITION,
            self::WITHOUT_COMPETITION,
            self::TARGET_COMPETITION,
            self::SPECIAL_RIGHT_COMPETITION,
        ];
    }


    public static function datasetQualifier($foreignerStatus, $educationLevel, $universityChoice)
    {
        if ($foreignerStatus) {
            return JsonAjaxField::data(self::foreignerGroup(), self::labelLists());
        } elseif ($educationLevel == AnketaHelper::SCHOOL_TYPE_SCHOOL_9
            || $educationLevel == AnketaHelper::SCHOOL_TYPE_PHD
            || $educationLevel == AnketaHelper::SCHOOL_TYPE_DOCTOR_SCIENCES
            || $universityChoice == AnketaHelper::SERGIEV_POSAD_BRANCH) {
            return JsonAjaxField::data([self::GENERAL_COMPETITION], self::labelLists());
        } elseif (in_array($educationLevel, AnketaHelper::educationLevelSpecialRight())) {
            return JsonAjaxField::data(self::CPKGroup(), self::labelLists());
        } elseif ($universityChoice == AnketaHelper::HEAD_UNIVERSITY) {
            return JsonAjaxField::data([self::GENERAL_COMPETITION, self::TARGET_COMPETITION], self::labelLists());
        }
        return JsonAjaxField::data([self::GENERAL_COMPETITION], self::labelLists());

    }
}