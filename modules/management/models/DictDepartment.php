<?php


namespace modules\management\models;

use modules\management\forms\DictDepartmentForm;
use modules\management\models\queries\DictDepartmentQuery;
use yii\db\ActiveRecord;

/**
 * @property $name string
 * @property $name_short string
 * @property $id integer
 */
class DictDepartment extends ActiveRecord
{

    public static function tableName()
    {
        return "{{dict_department}}";
    }

    public static function create(DictDepartmentForm $form)
    {
        $model = new static();
        $model->data($form);
        return $model;
    }

    public function data(DictDepartmentForm $form)
    {
        $this->name = $form->name;
        $this->name_short = $form->name_short;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ИД',
            'name' => 'Наименование отдела',
            'name_short' => 'Краткое наименование отдела',
        ];
    }

    public static function find(): DictDepartmentQuery
    {
        return new DictDepartmentQuery(static::class);
    }
}