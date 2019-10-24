<?php

namespace backend\models\dictionary;

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

    public static function create(string $fullName): self
    {
        $faculty = new static();
        $faculty->full_name = $fullName;
        return $faculty;
    }

    public function edit(string $fullName): void
    {
        $this->full_name = $fullName;
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