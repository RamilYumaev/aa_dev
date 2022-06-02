<?php
namespace modules\superservice\forms;
use modules\superservice\components\data\DocumentTypeVersionList;

class DocumentsFields
{
    private $data;

    public function __construct()
    {
        $this->data = (new DocumentTypeVersionList())->getArray()->filter(function ($v) {
            return key_exists('FieldsDescription', $v);
        });
    }

    public function data($array) {
        $data = '';
        if(is_array($array)) {
            foreach ($array as $key => $value) {
                if(key_exists($key, $this->getFields()['clsName'])) {
                    $class = '\\modules\\superservice\\components\\data\\'.$this->getFields()['clsName'][$key];
                    $data .=   $this->getFields()['descriptions'][$key].": ".
                        ($value ?  (new $class())->getArray()->index('Id')[$value]["Name"] : $value);
                }else {
                    $data .= $this->getFields()['descriptions'][$key].": ".$value. "\n";
                }
            }
        }
        return $data;
    }

    private function getFields() {
        $fields = [];
        foreach ($this->data as $cc) {
            $array = $cc['FieldsDescription']['FieldDescription'];
            foreach ($array as $key2 => $value) {
                if(is_array($value)) {
                    $fields = $this->addFields($fields, $value);
                }
            }
            if(key_exists('Name', $array)) {
                $fields = $this->addFields($fields, $array);
            }
        }
        return $fields;
    }

    private function addFields($fields, $array)
    {
        if(key_exists('ClsName', $array)) {
            $fields['clsName'][$array['Name']] = $array['ClsName'];
        }
        $fields['descriptions'][$array['Name']] = $array['Description'];

        return $fields;
    }

}
