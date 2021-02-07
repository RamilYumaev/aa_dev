<?php


namespace modules\management\models;

use modules\management\forms\DictTaskForm;
use modules\management\models\queries\DictTaskQuery;
use yii\db\ActiveRecord;

/**
 * @property $name string
 * @property $color string
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
        $this->color = $form->color;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ИД',
            'name' => 'Наименовнаие функции',
            'color' => "Цвет"
        ];
    }

    public static function find(): DictTaskQuery
    {
        return new DictTaskQuery(static::class);
    }
}