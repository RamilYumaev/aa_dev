<?php


namespace dictionary\helpers;


use dictionary\models\Templates;
use yii\helpers\ArrayHelper;

class TemplatesHelper
{
    const TYPE_dictionary = 1;
    const TYPE_DOCUMENTS = 2;

    public static function typeTemplatesList()
    {
        return [
            self::TYPE_dictionary => 'Для олимпиад',
            self::TYPE_DOCUMENTS => 'Для документов цпк',
        ];
    }

    public static function templatesType()
    {
        return [
            self::TYPE_dictionary, self::TYPE_DOCUMENTS
        ];
    }

    public static function typeTemplateName($key): string
    {
        return ArrayHelper::getValue(self::typeTemplatesList(), $key);
    }

    public static function templatesList(): array
    {
        return ArrayHelper::map(Templates::find()->all(), "id", 'name');
    }

    public static function templatesName($key): string
    {
        return ArrayHelper::getValue(self::templatesList(), $key);
    }

    public static function templatesNameForUserList(): array
    {
        return ArrayHelper::map(Templates::find()->all(), "id", 'name_for_user');
    }

    public static function templatesNameForUser($key): string
    {
        return ArrayHelper::getValue(self::templatesNameForUserList(), $key);
    }

    public static function templatesLabelOLympic () {
        return [
            '{Фамилия И.О. председателя}',
            '{Название мероприятия в родительном падеже}',
            '{классы/курсы участников}',
            '{дата и время начала регистрации}',
            '{дата и время завершения регистрации}',
            '{пункт3}',
            '{дата и время проведения очного тура}',
            '{адрес проведения очного тура}',
            '{продолжительность выполнения заданий очного тура в минутах}',
            '{выбранные конкурсные группы}',
            '{показ работ и апелляция}',
            '{текст аппеляции}',
            '{Требования к выполнению заданий заочного (дистанционного) тура}',
            '{Критерии оценивания заданий заочного (дистанционного) тура}',
            '{Требования к выполнению заданий очного тура}',
            '{Критерии оценивания заданий очного тура}',
        ];
    }
}