<?php

namespace dictionary\models;

use dictionary\forms\DictSpecialityCreateForm;
use dictionary\forms\DictSpecialityEditForm;
use yii\db\ActiveRecord;

class DictSpeciality extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dict_speciality';
    }

    public static function create(DictSpecialityCreateForm $form)
    {
        $speciality = new static();
        $speciality->name = $form->name;
        $speciality->code = $form->code;
        $speciality->short = $form->short;
        $speciality->edu_level = $form->edu_level;
        $speciality->series =  $form->series;
        $speciality->number =  $form->number;
        $speciality->date_end =  $form->date_end;
        $speciality->date_begin =  $form->date_begin;
        return $speciality;
    }

    public function edit(DictSpecialityEditForm $form)
    {
        $this->name = $form->name;
        $this->code = $form->code;
        $this->short = $form->short;
        $this->edu_level = $form->edu_level;
        $this->series =  $form->series;
        $this->number =  $form->number;
        $this->date_end =  $form->date_end;
        $this->date_begin =  $form->date_begin;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'code' => 'Код',
            'name' => 'Название',
            'short' => "Краткое наименоване на латинском",
            'edu_level' => "Уровень образования",
            'series' => 'Серия',
            'number' => 'Номер',
            'date_begin' => "Дата выдачи",
            'date_end' => "Срок действия"
        ];
    }

    public static function labels(): array
    {
        $speciality = new static();
        return $speciality->attributeLabels();
    }


    public function getCodeWithName()
    {
        return $this->code . ' - ' . $this->name;
    }

    public static function aisToSdoConverter($key)
    {
        $model = self::find()->andWhere(['ais_id'=> $key])->one();
        if($model !== null)
        {
            return $model->id;
        }

        throw new \DomainException("Специальность не найдена ".$key);
    }
}