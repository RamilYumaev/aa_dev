<?php


namespace testing\forms\question;

use testing\helpers\TestQuestionHelper;
use testing\models\Answer;
use yii\base\Model;

class AnswerForm extends Model
{
    public $name, $is_correct, $type, $answer_match;

    public function __construct($type, $config = [])
    {
        $this->type = $type;
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
                $this->addError('answer_match', 'Необходимо заполнить «Сопаставление».');
            }
            return true;
        }
        return false;
    }

    public function attributeLabels()
    {
        return Answer::labels();
    }

    public function getIsNewRecord () {
        return true;
    }
}