<?php

namespace dictionary\forms;

use dictionary\helpers\DictSpecialityHelper;
use dictionary\models\DictSpecialization;
use yii\base\Model;

class DictSpecializationEditForm extends Model
{
    public $name, $speciality_id, $_specialization, $ais_id;

    public function __construct(DictSpecialization $specialization, $config = [])
    {
        $this->name = $specialization->name;
        $this->speciality_id = $specialization->speciality_id;
        $this->ais_id = $specialization->ais_id;
        $this->_specialization = $specialization;

        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name', 'speciality_id'], 'required'],
            [['speciality_id', 'ais_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique', 'targetClass'=> DictSpecialization::class, 'filter' => ['<>', 'id', $this->_specialization->id],
                'message' => 'Такая образовательная программа уже есть'],
        ];
    }

    public function attributeLabels(): array
    {
        return DictSpecialization::labels();
    }

    public function specialityNameAndCodeList(): array
    {
        return DictSpecialityHelper::specialityNameAndCodeList();
    }

}