<?php


namespace dictionary\models;

use dictionary\forms\DictSpecializationCreateForm;
use dictionary\forms\DictSpecializationEditForm;

class DictSpecialization extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dict_specialization';
    }

    public static function create(DictSpecializationCreateForm $form)
    {
        $specialization = new static();
        $specialization->name = $form->name;
        $specialization->speciality_id = $form->speciality_id;
        return $specialization;
    }

    public function edit(DictSpecializationEditForm $form)
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
            'name' => 'Название',
            'speciality_id' => 'Направление подготовки',
        ];
    }

    public static function labels(): array
    {
        $specialization = new static();
        return $specialization->attributeLabels();
    }
}