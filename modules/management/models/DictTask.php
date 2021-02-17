<?php


namespace modules\management\models;

use modules\management\forms\DictTaskForm;
use modules\management\models\queries\DictTaskQuery;
use yii\db\ActiveRecord;

/**
 * @property $name string
 * @property $color string
 * @property $description string
 * @property $id integer
 */
class DictTask extends ActiveRecord
{

    public static function tableName()
    {
        return "{{dict_task}}";
    }

    public static function create(DictTaskForm $form)
    {
        $model = new static();
        $model->data($form);
        return $model;
    }

    public function data(DictTaskForm $form)
    {
        $this->name = $form->name;
        $this->description = $form->description;
        $this->color = $form->color;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ИД',
            'name' => 'Наименование функции/Краткое наименование',
            'color' => "Цвет",
            'description' => 'Описание',
        ];
    }

    public function  getManagementTask() {
        return $this->hasMany(ManagementTask::class, ['dict_task_id' => 'id']);
    }

    public static function find(): DictTaskQuery
    {
        return new DictTaskQuery(static::class);
    }
}