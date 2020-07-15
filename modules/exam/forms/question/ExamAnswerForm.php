<?php


namespace modules\exam\forms\question;

use modules\exam\models\ExamAnswer;
use testing\helpers\TestQuestionHelper;
use yii\base\Model;

class ExamAnswerForm extends Model
{
    public $name, $is_correct, $type, $answer_match;
    public $id;

    public function __construct(ExamAnswer $answer = null, $config = [])
    {
        if ($answer) {
            $this->id = $answer->id;
            $this->name = $answer->name;
            $this->is_correct = $answer->is_correct;
            $this->answer_match = $answer->answer_match;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['is_correct'], 'boolean'],
            [['name','answer_match' ], 'string'],
        ];
    }

    public function beforeValidate()
    {
        if (parent::beforevalidate()) {
            if (($this->type == TestQuestionHelper::TYPE_SELECT_ONE ||
                $this->type == TestQuestionHelper::TYPE_SELECT ||
                $this->type == TestQuestionHelper::TYPE_ANSWER_SHORT) && empty($this->name)) {
                $this->addError('name', 'Необходимо заполнить «Наименование».');
            }
            if ($this->type == TestQuestionHelper::TYPE_MATCHING && empty($this->answer_match)) {
                $this->addError('answer_match', 'Необходимо заполнить «Сопоставление».');
            }
            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return (new ExamAnswer())->attributeLabels();
    }

}