<?php

namespace dictionary\forms;

use dictionary\helpers\DictClassHelper;
use dictionary\models\DictClass;
use yii\base\Model;

class DictClassEditForm extends Model
{

    public $name;
    public $type;
    public $_dictClass;

    /**
     * {@inheritdoc}
     */
    public function __construct(DictClass $dictClass, $config = [])
    {
        $this->name = $dictClass->name;
        $this->type = $dictClass->type;
        $this->_dictClass = $dictClass;

        parent::__construct($config);
    }


    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['type'], 'integer'],
            [['name'], 'string', 'max' => 56],
            [['name'], 'unique', 'targetClass' => DictClass::class, 'filter' => ['<>', 'id', $this->_dictClass->id], 'targetAttribute' => ['name', 'type']],
            ['type', 'in', 'range' => DictClassHelper::types(), 'allowArray' => true]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return DictClass::labels();
    }

    public function classes(): array
    {
        $result = [];
        for ($i = 1; $i <= 11; $i++) {
            $result[$i] = $i;

        }
        return $result;
    }

    public function typeList(): array
    {
        return DictClassHelper::typeOfClass();
    }


}