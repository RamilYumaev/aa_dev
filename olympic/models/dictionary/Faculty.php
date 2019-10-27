<?php

namespace olympic\models\dictionary;

use olympic\forms\dictionary\FacultyForm;

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

    public static function create(FacultyForm $form): self
    {
        $faculty = new static();
        $faculty->full_name = $form->full_name;
        return $faculty;
    }

    public function edit(FacultyForm $form): void
    {
        $this->full_name = $form->full_name;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ИД',
            'full_name' => 'Полное название',
        ];
    }

    public static function labels(): array
    {
        $faculty = new static();
        return $faculty->attributeLabels();
    }
}