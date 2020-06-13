<?php


namespace modules\dictionary\models;


use common\moderation\interfaces\YiiActiveRecordAndModeration;
use modules\dictionary\forms\DictOrganizationForm;

/**
 * Class DictOrganizations
 * @package modules\dictionary\models
 * @property $name string
 * @property $ais_id  integer
 */
class DictOrganizations extends YiiActiveRecordAndModeration
{

    public static function tableName()
    {
        return "{{dict_organizations}}";
    }

    public function titleModeration(): string
    {
        return "Целевые организации";
    }

    public static function create(DictOrganizationForm $form)
    {
        $model = new static();
        $model->data($form);
        return $model;
    }

    public static function createNameUser($name)
    {
        $model = new static();
        $model->setName($name);
        return $model;
    }

    public function data(DictOrganizationForm $form)
    {
        $this->name = $form->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setAisId($id)
    {
        $this->ais_id = $id;
    }

    public function moderationAttributes($value): array
    {
        return [
            "name" => $value,
        ];
    }

    public function attributeLabels()
    {
        return [
            "name" => "Наименование организации",
        ];
    }
}