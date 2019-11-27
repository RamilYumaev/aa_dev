<?php


namespace testing\forms\question;

use testing\helpers\TestQuestionHelper;
use testing\models\Answer;
use testing\models\AnswerCloze;
use yii\base\Model;

class AnswerClozeForm extends Model
{
    public $name, $is_correct, $type;

    public function __construct($type, $config = [])
    {
        $this->type = $type;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['is_correct'], 'boolean'],
            [['name'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return AnswerCloze::labels();
    }

    public function getIsNewRecord () {
        return true;
    }
}