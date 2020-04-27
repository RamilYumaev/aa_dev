<?php

namespace dictionary\forms;

use dictionary\models\DictSpeciality;
use yii\base\Model;

class DictSpecialityEditForm extends Model
{
    public $code, $name, $_speciality, $short;

    public function __construct(DictSpeciality $speciality, $config = [])
    {
        $this->name = $speciality->name;
        $this->code = $speciality->code;
        $this->short = $speciality->short;
        $this->_speciality = $speciality;
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
                ['code', 'unique', 'targetClass' => DictSpeciality::class, 'filter' => ['<>', 'id', $this->_speciality->id],'message' => 'Такое направление подготовки уже есть'],
                ['short', 'unique', 'targetClass' => DictSpeciality::class, 'filter' => ['<>', 'id', $this->_speciality->id],'message' => 'Такое краткое наименовние уже есть'],
        ];
    }

    public function attributeLabels(): array
    {
        return DictSpeciality::labels();
    }

}