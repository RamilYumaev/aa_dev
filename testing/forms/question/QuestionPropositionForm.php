<?php
namespace testing\forms\question;

use testing\helpers\TestQuestionHelper;
use testing\models\QuestionProposition;
use testing\models\TestQuestion;
use yii\base\Model;

class QuestionPropositionForm extends Model
{
    public $name, $is_start, $type, $typeQuestion;

    public function __construct($type, $config = [])
    {
        $this->typeQuestion = $type;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['name', 'required'],
            [['is_start'], 'boolean'],
            [['type'], 'integer'],
            [['name'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return QuestionProposition::labels();
    }

    public function typeList() {
        return TestQuestionHelper::getAllTypeCloze();
    }

    public function getIsNewRecord () {
        return true;
    }
}