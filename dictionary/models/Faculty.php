<?php

namespace dictionary\models;

use dictionary\forms\FacultyCreateForm;
use dictionary\forms\FacultyEditForm;

class Faculty extends \yii\db\ActiveRecord
{
    //@TODO исправить название класса на DictFaculty

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dict_faculty';
    }

    public static function create(FacultyCreateForm $form): self
    {
        $faculty = new static();
        $faculty->full_name = $form->full_name;
        $faculty->filial = $form->filial;
        $faculty->ais_id = $form->ais_id;
        return $faculty;
    }

    public function edit(FacultyEditForm $form): void
    {
        $this->full_name = $form->full_name;
        $this->filial = $form->filial;
        $this->ais_is = $form->ais_id;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ИД',
            'full_name' => 'Полное название',
            'filial' => 'Филиал?',
            'ais_id'=> 'код в АИС ВУЗ'
        ];
    }

    public static function labels(): array
    {
        $faculty = new static();
        return $faculty->attributeLabels();
    }
}