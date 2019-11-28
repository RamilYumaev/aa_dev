<?php
namespace testing\forms\question;

use testing\helpers\TestQuestionHelper;
use testing\models\QuestionProposition;
use testing\models\TestQuestion;
use yii\base\Model;

class QuestionPropositionForm extends Model
{
    public $name, $is_start, $type, $typeQuestion, $id;

    public function __construct($type, QuestionProposition $questionProposition = null, $config = [])
    {
        $this->typeQuestion = $type;
        if ($questionProposition) {
            $this->id = $questionProposition->id;
            $this->name = $questionProposition->name;
            $this->is_start = $questionProposition->is_start;
            $this->type = $questionProposition->type;
        }
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