<?php

namespace dictionary\forms;

use dictionary\helpers\DictClassHelper;
use dictionary\models\DictClass;
use yii\base\Model;

class DictClassCreateForm extends Model
{

    public $name;
    public $type;

    /**
     * {@inheritdoc}
     */
    public function __construct($config = [])
    {
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
            [['name'], 'unique', 'targetClass' => DictClass::class, 'targetAttribute' => ['name', 'type']],
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
        for ($i = 0; $i <= 11; $i++) {
            $result[$i] = $i;

        }
        return $result;
    }

    public function typeList(): array
    {
        return DictClassHelper::typeOfClass();
    }


}