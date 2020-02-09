<?php

namespace dictionary\models;
use dictionary\forms\DictSchoolsPreModerationForm;
use dictionary\helpers\DictCountryHelper;

class DictSchoolsReport extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dict_schools_report';
    }

    public static function create($name, $country_id, $region_id)
    {
        $report = new static();
        $report->name = $name;
        $report->country_id = $country_id;
        $report->region_id = $country_id == DictCountryHelper::RUSSIA ? $region_id : null;

        return $report;
    }

    public function edit(DictSchoolsPreModerationForm $form)
    {
        $this->name = $form->name;
        $this->country_id = $form->country_id;
        $this->region_id = $form->region_id;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название учебной организации',
            'country_id' => 'Страна',
            'region_id' => 'Регион',
            'status' => "Статус",
            'email' => "Email",
        ];
    }

    public static function labels()
    {
        $report = new static();
        return $report->attributeLabels();
    }

}