<?php
namespace modules\superservice\components\data;


use modules\superservice\components\DataXml;

class OkcmList extends DataXml
{
    public function getNameTitle(): string
    {
       return 'Страны';
    }

    public function getAllAttributeWithLabel(): array
    {
        return [
            ['attribute' =>"Id", 'label'=> "ИД"],
            ['attribute' =>"Code", 'label'=> "Код"],
            ['attribute' =>"ShortName", 'label'=> "Наименование"],
            ['attribute' =>"FullName", 'label'=> "Полное наименование"],
            ['attribute' =>"Actual", 'label'=> 'Актуально', 'format'=> 'boolean'],
        ];
    }

    public function getDefaultMap()
    {
        return $this->getArray()
            ->sort(['ShortName'], SORT_ASC)->map('Id', 'ShortName');
    }
}