<?php
namespace modules\superservice\components\data;


use modules\superservice\components\DataXml;

class SubjectList extends DataXml
{
    public function getAllAttributeWithLabel(): array
    {
        return [
            ['attribute' =>"Id", 'label'=> "ИД"],
            ['attribute' =>"Name", 'label'=> "Наименование"],
            ['attribute' =>"Ege", 'label'=> 'ЕГЭ?', 'format'=> 'boolean'],
            ['attribute' =>"Actual", 'label'=> 'Актуально', 'format'=> 'boolean'],
        ];
    }

    public function getDefaultMap()
    {
        return $this->getArray()
            ->filter(function ($v) { return $v['Ege'] == 'true'; }, true)
            ->sort(['Name'], SORT_ASC)->map('Id', 'Name');
    }

    public function getNameTitle(): string
    {
       return 'Предметы';
    }
}