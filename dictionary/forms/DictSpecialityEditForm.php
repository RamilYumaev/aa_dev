<?php

namespace dictionary\forms;

use dictionary\models\DictSpeciality;
use yii\base\Model;

class DictSpecialityEditForm extends Model
{
    public $code, $name, $_speciality, $short, $edu_level, $series, $number, $date_begin, $date_end;

    public function __construct(DictSpeciality $speciality, $config = [])
    {
        $this->name = $speciality->name;
        $this->code = $speciality->code;
        $this->short = $speciality->short;
        $this->edu_level = $speciality->edu_level;
        $this->series =  $speciality->series;
        $this->number =  $speciality->number;
        $this->date_end =  $speciality->date_end;
        $this->date_begin =  $speciality->date_begin;
        $this->_speciality = $speciality;
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'name','short', 'edu_level','series','number', 'date_begin', 'date_end'], 'required'],
            [['date_begin', 'date_end'], 'date', 'format' => "Y-m-d"],
            [['name','series','number'], 'string'],
            [['code'], 'string', 'max' => 8],
            [['short'], 'string', 'max' => 10],
            [['edu_level'], 'integer'],
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