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

    public static function create($name, $speciality_id)
    {
        $specialization = new static();
        $specialization->name = $name;
        $specialization->speciality_id = $speciality_id;
        return $specialization;
    }

    public function edit($name, $speciality_id)
    {
        $this->name = $name;
        $this->speciality_id = $speciality_id;
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

    public static function aisToSdoConverter($key)
    {
        $model = self::find()->andWhere(['ais_id'=> $key])->one();

        if($model !== null)
        {
            return $model->id;
        }

        else return null;
    }
}