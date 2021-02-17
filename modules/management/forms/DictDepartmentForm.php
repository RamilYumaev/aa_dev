<?php

namespace modules\management\forms;


use modules\management\models\DictDepartment;
use yii\base\Model;

class DictDepartmentForm extends Model
{
    public $name, $name_short;
    private $_DictDepartment;

    public function __construct(DictDepartment $DictDepartment = null, $config = [])
    {
        if ($DictDepartment) {
            $this->setAttributes($DictDepartment->getAttributes(), false);
            $this->_DictDepartment = $DictDepartment;
        }

        parent::__construct($config);
    }
    

    public function defaultRules()
    {
        return [
            [['name','name_short'], 'required'],
            [['name', 'name_short'], 'string', 'max' => 255],
        ];
    }

    public function uniqueRules()
    {
        $arrayUnique = [['name'], 'unique', 'targetClass' => DictDepartment::class];
        if ($this->_DictDepartment) {
            return array_merge($arrayUnique, ['filter' => ['<>', 'id', $this->_DictDepartment->id]]);
        }

        return $arrayUnique;
    }

    public function rules()
    {
        return array_merge($this->defaultRules(), [$this->uniqueRules()]);
    }

    public function attributeLabels()
    {
        return (new DictDepartment())->attributeLabels();
    }
}