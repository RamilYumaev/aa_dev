<?php

namespace dictionary\forms;

use dictionary\helpers\DictSpecialityHelper;
use dictionary\models\DictSpecialization;
use yii\base\Model;

class DictSpecializationCreateForm extends Model
{
    public $name, $speciality_id;

    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name', 'speciality_id'], 'required'],
            [['speciality_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique', 'targetClass'=> DictSpecialization::class, 'message' => 'Такая образовательная программа уже есть'],
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