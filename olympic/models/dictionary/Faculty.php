<?php

<<<<<<< HEAD:backend/models/dictionary/Faculty.php
namespace backend\models\dictionary;
=======
namespace  olympic\models\dictionary;

use olympic\forms\dictionary\FacultyForm;
>>>>>>> #10:olympic/models/dictionary/Faculty.php

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

<<<<<<< HEAD:backend/models/dictionary/Faculty.php
    public static function create(string $fullName): self
    {
        $faculty = new static();
        $faculty->full_name = $fullName;
        return $faculty;
    }

    public function edit(string $fullName): void
=======
    public static function create (FacultyForm $form) : self
    {
        $faculty =  new static();
        $faculty->full_name = $form->full_name;
        return $faculty;
    }

    public function edit(FacultyForm $form) :void
>>>>>>> #10:olympic/models/dictionary/Faculty.php
    {
        $this->full_name = $form->full_name;
    }

    /**
     * {@inheritdoc}
     */cd
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