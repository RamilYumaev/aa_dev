<?php
namespace modules\superservice\components;

abstract class DataXml
{
    private $array;

    const KEY_NAME = 'Name';

    public function nameFileXml() {
        $class = new \ReflectionClass($this);
        return $class->getShortName();
    }

    public function __construct()
    {
        $this->array = new ConvertXmlToArray($this->nameFileXml());
    }

    public function getArray() {
        return $this->array;
    }

    public function getArrayForView() {
        return $this->getArray()->getArrayWithFirstKeyName();
    }

    public function getDefaultMap() {
        return $this->getArray()->sort(['Name'], [SORT_ASC])->map('Id', 'Name');
    }

    public function getKeys() {
        return array_keys($this->getArray()->getArrayWithFirstKeyName()[0]);
    }

    public function getAllAttributeWithLabel(): array
    {
        return [
            ['attribute' =>"Id", 'label'=> "ИД"],
            ['attribute' =>"Name", 'label'=> "Наименование"],
            ['attribute' =>"Actual", 'label'=> 'Актуально', 'format'=> 'boolean'],
        ];
    }

    abstract public function getNameTitle(): string;
}