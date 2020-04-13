<?php

namespace dictionary\models;

use dictionary\forms\FacultyCreateForm;
use dictionary\forms\FacultyEditForm;

class Faculty extends \yii\db\ActiveRecord
{
    //@TODO исправить название класса на DictFaculty

    const COLLAGE = 19;
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
        return $faculty;
    }

    public function edit(FacultyEditForm $form): void
    {
        $this->full_name = $form->full_name;
        $this->filial = $form->filial;
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
        ];
    }

    public static function labels(): array
    {
        $faculty = new static();
        return $faculty->attributeLabels();
    }

    public function isCollage(): bool
    {
        return  $this->id == self::COLLAGE;
    }

    public static function aisToSdoConverter($key)
    {
        $model = self::find()->andWhere(['ais_id'=> $key])->one();

        if($model !== null)
        {
            return $model->id;
        }

        throw new \DomainException("Факультет не найден ".$key);
    }

}