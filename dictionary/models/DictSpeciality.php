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
        return $speciality;
    }

    public function edit(DictSpecialityEditForm $form)
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
            [['ais_id'], 'integer'],
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