<?php
namespace modules\superservice\components\data;

use modules\superservice\components\DataXml;

class OlympicList extends DataXml
{
    public function getAllAttributeWithLabel(): array
    {
        return [
            ['attribute' =>"Id", 'label'=> "ИД"],
            ['attribute' =>"Name", 'label'=> "Наименование"],
            ['attribute' => 'OlympiadNumber', 'label'=> "Номер"],
            ['attribute' => 'OlympiadYear>', 'label'=> "Год олимпиады"],
            ['attribute' =>"Actual", 'label'=> 'Актуально', 'format'=> 'boolean'],
        ];
    }

    public function getNameTitle(): string
    {
       return "Уровень образования";
    }
}