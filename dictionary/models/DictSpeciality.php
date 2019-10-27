<?php

namespace dictionary\models;

use dictionary\forms\DictSpecialityForm;
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

    public static function create(DictSpecialityForm $form)
    {
        $speciality = new static();
        $speciality->name = $form->name;
        $speciality->code = $form->code;
        return $speciality;
    }

    public function edit(DictSpecialityForm $form)
    {
        $this->name = $form->name;
        $this->code = $form->code;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['name'], 'string'],
            [['code'], 'string', 'max' => 8],
            ['code', 'unique', 'message' => 'Такой направление подготовки уже есть'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'code' => 'Код',
            'name' => 'Название',
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
}