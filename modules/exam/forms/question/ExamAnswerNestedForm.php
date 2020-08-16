<?php


namespace modules\exam\forms\question;

use modules\exam\models\ExamAnswerNested;
use yii\base\Model;

class ExamAnswerNestedForm extends Model
{
    public $name, $is_correct, $id;

    public function __construct(ExamAnswerNested $answer = null, $config = [])
    {
        if ($answer) {
            $this->id = $answer->id;
            $this->name = $answer->name;
            $this->is_correct = $answer->is_correct;
        }else {
            $this->id = null;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['is_correct'], 'boolean'],
            [['id'], 'integer'],
            [['name'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return  (new ExamAnswerNested())->attributeLabels();
    }

    public function getIsNewRecord () {
        return true;
    }
}