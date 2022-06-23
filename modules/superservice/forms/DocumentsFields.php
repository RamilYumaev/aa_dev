<?php
namespace modules\superservice\forms;
use modules\superservice\components\data\DocumentTypeList;
use modules\superservice\components\data\DocumentTypeVersionList;

class DocumentsFields
{
    private static $instance = null;

    public static function getDocumentTypeVersionList()
    {
        if (null === self::$instance)
        {
            self::$instance = (new DocumentTypeVersionList())->getArray();
        }
        return self::$instance;
    }

    public static function getDocumentTypeList()
    {
        return (new DocumentTypeList())->getArray();
    }

    public static function data($array) {
        $data = '';
        if(is_array($array)) {
            $version = $array['version_document'];
            foreach ($array as $key => $value) {
                if($key == 'version_document') {
                    continue;
                }
                if(key_exists('clsName', self::getFields($version)) && key_exists($key, self::getFields($version)['clsName'])) {
                    $class = '\\modules\\superservice\\components\\data\\'.self::getFields($version)['clsName'][$key];
                    $data .=   self::getFields($version)['descriptions'][$key].": ".
                        ($value ?  (new $class())->getArray()->index('Id')[$value][$class::KEY_NAME] : $value)."; ";
                }else {
                    $data .= self::getFields($version)['descriptions'][$key].": ".$value. ";\n ";
                }
            }
        }
        return $data;
    }

    private static function getFields($version) {
        $fields = [];
        $data = self::getDocumentTypeVersionList()->filter(function ($v) use ($version) {
            return $v['Id'] == $version && key_exists('FieldsDescription', $v);
        });
        foreach ($data as $cc) {
            $array = $cc['FieldsDescription']['FieldDescription'];
            foreach ($array as $key2 => $value) {
                if(is_array($value)) {
                    $fields = self::addFields($fields, $value);
                }
            }
            if(key_exists('Name', $array)) {
                $fields = self::addFields($fields, $array);
            }
        }
        return $fields;
    }

    private static function addFields($fields, $array)
    {
        if(key_exists('ClsName', $array)) {
            $fields['clsName'][$array['Name']] = $array['ClsName'];
        }
        $fields['descriptions'][$array['Name']] = $array['Description'];

        return $fields;
    }

    public static  function getTypeDocument($id) {
        $data = array_values(self::getDocumentTypeList()->filter(function ($value)  use($id)  {
            return $value['Id'] == $id;
        }));
        return $data? $data[0]['Name'] : '';
    }

    public static function getTypeVersionDocumentList($id) {
         $data = array_values(self::getDocumentTypeVersionList()
            ->getArrayWithProperties((new DocumentTypeVersionList())->getProperties(), true)
            ->filter(function ($value)  use($id) {
                return $value['Id'] == $id;
            }));
         if($data) {
             if(self::getCountTypeVersion($data[0]['IdDocumentTypeKey']) > 1) {
                 return $data[0]['DocVersion'];
             }
             return "Нет версии";
         }else {
             return '';
         }
    }

    private static function getCountTypeVersion($id) {
        return count(self::getDocumentTypeVersionList()->getArrayWithProperties((new DocumentTypeVersionList())->getProperties(), true)->filter(function ($value)  use($id) {
            return $value['IdDocumentTypeKey'] == $id;
        }));
    }
}
