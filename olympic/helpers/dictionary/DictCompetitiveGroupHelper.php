<?php


namespace olympic\helpers\dictionary;


use yii\helpers\ArrayHelper;

class DictCompetitiveGroupHelper
{
    // уровни добранования
    const EDUCATION_LEVEL_SPO = 0;
    const EDUCATION_LEVEL_BACHELOR = 1;
    const EDUCATION_LEVEL_MAGISTER = 2;
    const EDUCATION_LEVEL_GRADUATE_SCHOOL = 3;

    // Формы обучения
    const EDU_FORM_OCH = 1;
    const EDU_FORM_OCH_ZAOCH = 2;
    const EDU_FORM_ZAOCH = 3;

    // виды финансирования
    const FINANCING_TYPE_BUDGET = 1;
    const FINANCING_TYPE_CONTRACT = 2;

    // тип конкурса
    const USUAL = 0;
    const SPECIAL_RIGHT = 1;
    const TARGET_PLACE = 2;

    public static function getEduForms(): array
    {
        return [self::EDU_FORM_OCH => 'очная',
            self::EDU_FORM_OCH_ZAOCH => 'очно-заочная',
            self::EDU_FORM_ZAOCH => 'заочная'];
    }

    public static function getFinancingTypes(): array
    {
        return [self::FINANCING_TYPE_BUDGET => 'Бюджет', self::FINANCING_TYPE_CONTRACT => 'Договор'];
    }

    public static function getEduLevels(): array
    {
        return [self::EDUCATION_LEVEL_SPO => 'СПО', self::EDUCATION_LEVEL_BACHELOR => 'Бакалавриат',
            self::EDUCATION_LEVEL_MAGISTER => 'Магистратура', self::EDUCATION_LEVEL_GRADUATE_SCHOOL => 'Аспирантура'];
    }

    public static function getSpecialRight(): array
    {
        return [self::USUAL => 'Обычная', self::SPECIAL_RIGHT => 'Квота', self::TARGET_PLACE => 'Целевое'];
    }

    public static function forms(): array
    {
        return [
            self::EDUCATION_LEVEL_SPO,
            self::EDUCATION_LEVEL_BACHELOR,
            self::EDUCATION_LEVEL_MAGISTER,
            self::EDUCATION_LEVEL_GRADUATE_SCHOOL
        ];
    }

    public static function specialRight(): array
    {
        return [self::USUAL, self::SPECIAL_RIGHT, self::TARGET_PLACE];
    }

    public static function eduLevels(): array
    {
        return [self::EDUCATION_LEVEL_SPO, self::EDUCATION_LEVEL_BACHELOR,
            self::EDUCATION_LEVEL_MAGISTER, self::EDUCATION_LEVEL_GRADUATE_SCHOOL];
    }

    public static function financingTypes(): array
    {
        return [self::FINANCING_TYPE_BUDGET, self::FINANCING_TYPE_CONTRACT];

    }

    public static function formName($key): string
    {
        return ArrayHelper::getValue(self::getEduForms(), $key);
    }

    public static function financingTypeName($key): string
    {
        return ArrayHelper::getValue(self::getFinancingTypes(), $key);
    }

    public static function eduLevelName($key): string
    {
        return ArrayHelper::getValue(self::getEduLevels(), $key);
    }

    public static function specialRightName($key): string
    {
        return ArrayHelper::getValue(self::getSpecialRight(), $key);
    }


}