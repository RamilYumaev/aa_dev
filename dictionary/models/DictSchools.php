<?php


namespace dictionary\models;


use dictionary\forms\DictSchoolsCreateForm;
use dictionary\forms\DictSchoolsEditForm;
use dictionary\forms\DictSpecialityCreateForm;
use dictionary\models\queries\DictSchoolsQuery;

class DictSchools extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dict_schools';
    }

    public static function create(DictSchoolsCreateForm $form)
    {
        $schools = new static();
        $schools->name = $form->name;
        $schools->country_id = $form->country_id;
        $schools->region_id = $form->region_id;
        return $schools;
    }

    public function edit(DictSchoolsEditForm $form)
    {
        $this->name = $form->name;
        $this->country_id = $form->country_id;
        $this->region_id = $form->region_id;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название учебной организации',
            'country_id' => 'Страна, где расположена учебная организация',
            'region_id' => 'Регион, где расположена учебная организация',
        ];
    }

    public static function labels(): array
    {
        $schools = new static();
        return $schools->attributeLabels();
    }

    public static function find(): DictSchoolsQuery
    {
        return new DictSchoolsQuery(static::class);
    }


}