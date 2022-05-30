<?php
namespace modules\superservice\components\data;

use modules\superservice\components\DataXml;

class DirectionList extends DataXml
{
    private static $instance = null;

    public static function getInstance()
    {
        if (null === self::$instance)
        {
            self::$instance = (new DocumentEducationLevelList())->getArray()->index('Id');
        }
        return self::$instance;
    }

    public function getAllAttributeWithLabel(): array
    {
        return [
            ['attribute' =>"Id", 'label'=> "ИД"],
            ['attribute' =>"Code", 'label'=> "Код"],
            ['attribute' =>"Name", 'label'=> "Name"],
            ['attribute' =>"Section", 'label'=> "Секция"],
            ['attribute' =>"IdParent", 'label'=> "IdParent"],
            ['attribute' =>"IdEducationLevel", 'label'=> "Уровень образования"],
            ['attribute' =>"Actual", 'label'=> 'Актуально', 'format'=> 'boolean'],
        ];
    }

    /**
     * @param $value
     * @return mixed
     * @throws \Exception
     */
    public function getEducationLevel($value) {

        return (new DocumentEducationLevelList())->getArray()->index('id');
    }

    public function getArrayForView()
    {
        return $this->getArray()->getArrayWithProperties($this->getProperties());
    }

    public function getDefaultMap()
    {
        return $this->getArray()->map('Id', function ($v) {
            return $v['Code']." ".$v['Name']. ' '.self::getInstance()[$v['IdEducationLevel']]['Name'];;
        });
    }

    public function getProperties() {

        return [
            'Id',
            'Code',
            'Name',
            'Section',
            'IdParent',
            ['key' => 'IdEducationLevel', 'value' => function($v) {return self::getInstance()[$v['IdEducationLevel']]['Name']; }],
            'Actual',
        ];
    }

    public function getNameTitle(): string
    {
       return "Специальность по ОКСО";
    }
}