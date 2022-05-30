<?php
namespace modules\superservice\components\data;


use modules\superservice\components\DataXml;

class DocumentTypeList extends DataXml
{
    /**
     * @param $name
     * @return mixed
     * @throws \Exception
     */
    public function getCategory($name) {
        return (new DocumentCategoryList())->getArray()->indexValue('Id', $name);
    }

    public function getAllAttributeWithLabel(): array
    {
        return [
            ['attribute' =>"Id", 'label'=> "ИД"],
            ['attribute' =>"Name", 'label'=> "Наименование"],
            ['attribute' =>"Actual", 'label'=> 'Актуально', 'format'=> 'boolean'],
            ['attribute' =>"IdCategory", 'label'=> 'Категория', 'value'=> function ($model) {
               return $this->getCategory($model["IdCategory"])['Name'];
            }],
        ];
    }

    public function getNameTitle(): string
    {
       return 'Типы документов';
    }
}