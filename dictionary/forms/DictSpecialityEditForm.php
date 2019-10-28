<?php

namespace dictionary\forms;

use dictionary\models\DictSpeciality;
use yii\base\Model;

class DictSpecialityEditForm extends Model
{
    public $code, $name, $_speciality;

    public function __construct(DictSpeciality $speciality, $config = [])
    {
        $this->name = $speciality->name;
        $this->code = $speciality->code;
        $this->_speciality = $speciality;
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['name'], 'string'],
            [['code'], 'string', 'max' => 8],
            ['code', 'unique', 'targetClass' => DictSpeciality::class, 'filter' => ['<>', 'id', $this->_speciality->id], 'message' => 'Такой направление подготовки уже есть'],
        ];
    }

    public function attributeLabels(): array
    {
        return DictSpeciality::labels();
    }

}