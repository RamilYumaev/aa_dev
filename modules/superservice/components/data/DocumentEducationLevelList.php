<?php
namespace modules\superservice\components\data;

use modules\superservice\components\DataXml;

class DocumentEducationLevelList extends DataXml
{
    public function getAllAttributeWithLabel(): array
    {
        return [
            ['attribute' =>"Id", 'label'=> "ИД"],
            ['attribute' =>"Name", 'label'=> "Наименование"],
            ['attribute' =>"Actual", 'label'=> 'Актуально', 'format'=> 'boolean'],
        ];
    }

    public function getNameTitle(): string
    {
       return "Уровень образования";
    }
}