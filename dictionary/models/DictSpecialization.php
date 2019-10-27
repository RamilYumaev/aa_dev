<?php


namespace dictionary\models;

use dictionary\forms\DictSpecializationForm;

class DictSpecialization extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dict_specialization';
    }

    public static function create(DictSpecializationForm $form)
    {
        $specialization = new static();
        $specialization->name = $form->name;
        $specialization->speciality_id = $form->speciality_id;
        return $specialization;
    }

    public function edit(DictSpecializationForm $form)
    {
        $this->name = $form->name;
        $this->speciality_id = $form->speciality_id;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Навзвание',
            'speciality_id' => 'Направление подготовки',
            [['name'], 'unique', 'message' => 'Такая образовательная организация уже есть'],
        ];
    }

    public static function labels(): array
    {
        $specialization = new static();
        return $specialization->attributeLabels();
    }
}