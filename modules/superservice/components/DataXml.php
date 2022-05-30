<?php
namespace modules\superservice\components;

abstract class DataXml
{
    private $array;

    public function __construct()
    {
        $class = new \ReflectionClass($this);
        $this->array = new ConvertXmlToArray($class->getShortName());
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

    abstract public function getAllAttributeWithLabel(): array;

    abstract public function getNameTitle(): string;
}