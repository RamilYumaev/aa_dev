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
        return $speciality;
    }

    public function edit(DictSpecialityEditForm $form)
    {
        $this->name = $form->name;
        $this->code = $form->code;
        $this->short = $form->short;
        $this->edu_level = $form->edu_level;
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
            'edu_level' => "Уровень образования"
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