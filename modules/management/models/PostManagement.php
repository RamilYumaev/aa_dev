<?php


namespace modules\management\models;

use modules\management\forms\PostManagementForm;
use modules\management\models\queries\PostManagementQuery;
use yii\db\ActiveRecord;

/**
 * @property $name string
 * @property $name_short string
 * @property $is_director bool
 * @property $id integer
 */
class PostManagement extends ActiveRecord
{

    public static function tableName()
    {
        return "{{post_management}}";
    }

    public static function create(PostManagementForm $form)
    {
        $model = new static();
        $model->data($form);
        return $model;
    }

    public function data(PostManagementForm $form)
    {
        $this->name = $form->name;
        $this->name_short = $form->name_short;
        $this->is_director = $form->is_director;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ИД',
            'name' => 'Наименовнаие',
            'name_short' => 'Наименовнаие',
            'is_director' => "Постановщик задач?"
        ];
    }

    public function getManagementTasks() {
        return $this->hasMany(ManagementTask::class, ['post_management_id'=> 'id']);
    }

    public static function find(): PostManagementQuery
    {
        return new PostManagementQuery(static::class);
    }
}