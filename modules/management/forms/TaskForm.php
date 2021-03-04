<?php

namespace modules\management\forms;

use modules\management\models\Task;
use yii\base\Model;

class TaskForm extends Model
{
    public $text, $title, $dict_task_id, $director_user_id, $position, $responsible_user_id, $date_end, $note;
    private $task;
    const SCENARIO_NOTE_REWORK = 'note_rework';
    public function __construct(Task $task = null, $config = [])
    {
        if ($task) {
            $this->setAttributes($task->getAttributes(), false);
            $this->task = $task;
        }else {
            $this->position =10;
        }


        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['title', 'dict_task_id', 'director_user_id', 'responsible_user_id', 'position','date_end'], 'required'],
            [['note'], 'required', 'on' => self::SCENARIO_NOTE_REWORK],
            [['title', 'note'], 'string', 'max' => 255],
            [['dict_task_id', 'director_user_id', 'responsible_user_id', 'position'], 'integer'],
            [['text'], 'string'],
            [['date_end'], 'safe'],
            [['date_end'], 'date', 'format' => 'yyyy-M-d H:m:s'],
        ];
    }


    public function attributeLabels()
    {
        return (new Task())->attributeLabels();
    }
}