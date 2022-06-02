<?php
namespace modules\superservice\components;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use function Google\Auth\Cache\set;

class ConvertXmlToArray
{
    private $nameFile;

    private $array;

    public function __construct($nameFile)
    {
        $this->nameFile = $nameFile;
    }

    public function convert()
    {
        $path = \Yii::getAlias('@modules').'/superservice/xml/'.$this->nameFile.'.xml';
        if(($xmlFile = @file_get_contents($path)) === false) {
            throw new \DomainException("Файл не найден");
        }
        $new = \simplexml_load_string($xmlFile);
        $con = Json::encode($new);
        $array = Json::decode($con, true);
        return $array;
    }

    /**
     * @return mixed
     */
    public function getArray()
    {
        return $this->array;
    }

    /**
     * @param mixed $array
     */
    public function setArray($array)
    {
        $this->array = $array;
    }

    public function map($key, $keyValue) {
        $array =   ArrayHelper::map($this->getArray() ?? $this->getArrayWithFirstKeyName(), $key, $keyValue);
        if (!$array) {
            return [];
        }
        return $array;
    }

    public function filter($condition, $isObject = false) {
        $array = $this->getArray() ?? $this->getArrayWithFirstKeyName();
        $array = array_filter($array, $condition);
        if (!$array) {
            return [];
        }
        $this->setArray($array);
        return $isObject ? $this : $array;
    }

    public function sort($keys, $sorting, $array = null) {
        $array = $this->getArray() ?? $this->getArrayWithFirstKeyName();
        ArrayHelper::multisort($array, $keys, $sorting);
        if (!$array) {
            return [];
        }
        $this->setArray($array);
        return $this;
    }

    public function column($key) {
        $array = ArrayHelper::getColumn($this->getArrayWithFirstKeyName(), $key);
        if (!$array) {
            return [];
        }
        return $array;
    }

    public function index($key) {
        $array = ArrayHelper::index($this->getArray() ?? $this->getArrayWithFirstKeyName(), $key);
         if (!$array) {
             return [];
         }
         return $array;
    }
    /**
     * @param $key
     * @param $valueKey
     * @return mixed
     * @throws \Exception
     */
    public function indexValue($key, $valueKey) {
        $array = $this->index($key);
        if (key_exists($valueKey, $array)) {
            return ArrayHelper::getValue($array, $valueKey);
        }
        return [];
    }

    public function getArrayWithFirstKeyName() {
        return $this->convert()[$this->getFirstKeyName()];
    }

    public function getArrayWithProperties($properties, $isObject = false, $array = null) {
        $array = $array ?? $this->getArrayWithFirstKeyName();
        $newArray = [];
        foreach ($array as $key =>$value) {
            foreach ($properties as $property) {
                if(is_array($property)) {
                    if(is_callable($property['value'])) {
                        $newArray[$key][$property['key']] = $property['value']($value);
                    }
                }
                elseif(key_exists($property, $value)) {
                    $newArray[$key][$property] = $value[$property];
                }
            }
        }
        $this->setArray($newArray);
        return $isObject ? $this : $newArray;
    }

    public function getFirstKeyName() {
        return array_key_first($this->convert());
    }
}
