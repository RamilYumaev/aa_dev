<?php

namespace modules\management\forms;


use modules\management\models\DictTask;
use yii\base\Model;

class DictTaskForm extends Model
{
    public $name, $color;
    private $_dictTask;
    public $description;

    public function __construct(DictTask $dictTask = null, $config = [])
    {
        if ($dictTask) {
            $this->setAttributes($dictTask->getAttributes(), false);
            $this->_dictTask = $dictTask;
        }

        parent::__construct($config);
    }
    

    public function defaultRules()
    {
        return [
            [['name', 'color','description'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['description'], 'string'],
            [['color'], 'string', 'max' => 7],
        ];
    }

    public function uniqueRules()
    {
        $arrayUnique = [['name'], 'unique', 'targetClass' => DictTask::class];
        if ($this->_dictTask) {
            return array_merge($arrayUnique, ['filter' => ['<>', 'id', $this->_dictTask->id]]);
        }

        return $arrayUnique;
    }

    public function rules()
    {
        return array_merge($this->defaultRules(), [$this->uniqueRules()]);
    }

    public function attributeLabels()
    {
        return (new DictTask())->attributeLabels();
    }
}