<?php

namespace modules\management\forms;

use modules\management\models\CommentTask;
use yii\base\Model;

class CommentTaskForm extends Model
{
    public $text;

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