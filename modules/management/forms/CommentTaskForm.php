<?php

namespace modules\management\forms;

use modules\management\models\CommentTask;
use yii\base\Model;

class CommentTaskForm extends Model
{
    public $text;
    public function __construct(CommentTask  $commentTask = null, $config = [])
    {
        if($commentTask) {
            $this->text = $commentTask->text;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['text'], 'required'],
            [['text'], 'string'],
        ];
    }


    public function attributeLabels()
    {
        return (new CommentTask())->attributeLabels();
    }
}