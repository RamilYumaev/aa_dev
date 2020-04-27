<?php

namespace dictionary\forms;

use dictionary\models\DictSpeciality;
use yii\base\Model;

class DictSpecialityCreateForm extends Model
{
    public $code, $name, $short;

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
            [['code', 'name','short'], 'required'],
            [['name'], 'string'],
            [['code'], 'string', 'max' => 8],
            [['short'], 'string', 'max' => 10],
            [['short'], 'match', 'pattern' => '/^[a-zA-Z0-9]+$/u'],
            ['code', 'unique', 'targetClass' => DictSpeciality::class, 'message' => 'Такое направление подготовки уже есть'],
            ['short', 'unique', 'targetClass' => DictSpeciality::class, 'message' => 'Такое краткое наименовние уже есть'],
        ];
    }

    public function attributeLabels(): array
    {
        return DictSpeciality::labels();
    }

}