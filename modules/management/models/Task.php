<?php
namespace modules\management\models;

use modules\management\forms\DictTaskForm;
use modules\management\forms\TaskForm;
use yii\db\ActiveRecord;

/**
 * @property $title string
 * @property $text string
 * @property $dict_task_id integer
 * @property $director_user_id integer
 * @property $responsible_user_id integer
 * @property $status integer
 * @property $date_begin string
 * @property $position integer
 * @property $date_end string
 * @property $id integer
 */
class Task extends ActiveRecord
{

    public static function tableName()
    {
        return "{{task}}";
    }

    public static function create(TaskForm $form)
    {
        $model = new static();
        $model->data($form);
        return $model;
    }

    public function data(TaskForm $form)
    {
        $this->title = $form->title;
        $this->text = $form->text;
        $this->dict_task_id = $form->dict_task_id;
        $this->director_user_id = $form->director_user_id;
        $this->position =  $form->position;
        $this->responsible_user_id = $form->responsible_user_id;
        $this->date_begin = $form->date_begin;
        $this->date_end = $form->date_end;
    }

    public function attributeLabels()
    {
        return [
            "id" => "ID",
            "title" => "Заголовок",
            "text" => "Описание",
            'dict_task_id' =>  "Тег задачи",
            'director_user_id' =>  "Постановщик",
            'responsible_user_id' => 'Ответственный',
            'date_begin' => 'Дата постановки',
            'status' => 'Статус',
            'position' => "Приоритет задачи",
            'date_end' =>  "Крайный срок",
        ];
    }

    /**
     * @throws \Exception
     */
    public function getDay(){
        $date = new \DateTimeImmutable($this->date_begin);
        return strtolower($date->format('l'));
    }

}