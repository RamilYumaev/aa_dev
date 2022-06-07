<?php
namespace modules\superservice\components\data;

use modules\superservice\components\DataXml;

class DocumentTypeVersionList extends DataXml
{
    const VERSION_DOC_2021 = 1;
    const VERSION_DOC_2022 = 2;

    private static $instance = null;

    public static function getDocumentTypeList()
    {
        if (null === self::$instance)
        {
            self::$instance = (new DocumentTypeList())->getArray()->index('Id');
        }
        return self::$instance;
    }

    public function getKeys() {
        $array = [];
        foreach ($this->getArrayForView() as $key => $value) {
            foreach ($value as $key1 => $item) {
                if(!is_array($item)) {
                    $array[] = $key1;
                }
            }
        }
        return array_unique($array);
    }

    public static function getVersions() {
        return [
            self::VERSION_DOC_2021 => [
                'name' => 'Версия 2021 года',
                'value' => 2021,
            ],
            self::VERSION_DOC_2022 => [
                'name' => 'Версия 2022 года',
                'value' => 2022,
            ],
        ];
    }

    public function getAllAttributeWithLabel(): array
    {
        return [
            ['attribute' =>"Id", 'label'=> "ИД"],
            ['attribute' =>"Description", 'label'=> 'Описание',],
            ['attribute' =>"DocVersion", 'label'=> 'Версия докмента'],
            ['attribute' =>"IdDocumentType", 'label'=> 'Тип документа'],
        ];
    }

    public function getArrayForView()
    {
        return $this->getArray()->getArrayWithProperties($this->getProperties());
    }

    public function getProperties() {
        return [
            'Id',
            ['key' => 'DocVersion', 'value' => function($v) { return self::getVersions()[$v['DocVersion']]['name'];}],
            ['key' => 'IdDocumentType', 'value' => function($v) {return self::getDocumentTypeList()[$v['IdDocumentType']]['Name'];}],
            'FieldsDescription',
            'Description',
            ['key' => 'DocVersionId', 'value' => function($v) { return $v['DocVersion'];}],
            ['key' => 'IdDocumentTypeKey', 'value' => function($v) {return $v['IdDocumentType'];}],
        ];
    }

    public static function getPropertyForSelect() {
        return [
            'Id',
            ['key' => 'DocVersion',
                'value' => function($v)
                { return self::getVersions()[$v['DocVersion']]['name'];}],
            ['key' => 'Name',
                'value' => function($v) {return self::getDocumentTypeList()[$v['IdDocumentType']]['Name'];}],
            'IdDocumentType',
            ['key' => 'IdCategory', 'value' => function($v) {return self::getDocumentTypeList()[$v['IdDocumentType']]['IdCategory'];}],
        ];
    }

    public function getChildren()
    {
        $data['rowOptions'] = function ($model) {
            return ['class' => 'warning'];
        };
        $data['afterRow'] = function ($model, $key, $index, $grid) {
            var_dump($model);
        };
    }

    public function getNameTitle(): string
    {
        return 'Версия документов';
    }
}