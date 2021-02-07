<?php

namespace modules\management\forms;

use modules\management\models\Task;
use yii\base\Model;

class TaskForm extends Model
{
    public $text, $title, $dict_task_id, $director_user_id, $position, $responsible_user_id, $date_begin, $date_end, $day;
    private $task;

    public function __construct(Task $task = null, $config = [])
    {
        if ($task) {
            $this->setAttributes($task->getAttributes(), false);
            $this->day = $task->getDay();
            $this->task = $task;
        }

        parent::__construct($config);
    }
    

    public function rules()
    {
        return [
            [['title', 'dict_task_id', 'director_user_id', 'responsible_user_id', 'position', 'date_begin','date_end'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['dict_task_id', 'director_user_id', 'responsible_user_id', 'position'], 'integer'],
            [['text'], 'string'],
            [['date_end','date_begin'], 'safe'],
        ];
    }


    public function attributeLabels()
    {
        return (new Task())->attributeLabels()+['time_end'=>"Время"];
    }
}