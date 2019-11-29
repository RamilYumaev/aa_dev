<?php

namespace testing\forms\question;
use common\auth\forms\CompositeForm;
use testing\helpers\TestQuestionGroupHelper;
use testing\helpers\TestQuestionHelper;
use testing\models\TestQuestion;

class TestQuestionTypesFileForm extends CompositeForm
{
    public $file_type_id;

    public function __construct ($group_id, $type, TestQuestion $question = null, $config = [])
    {
        if ($question) {
            $this->question = new TestQuestionEditForm($question);
             $this->file_type_id = $question->file_type_id;
        } else {
            $this->question = new TestQuestionForm($group_id, $type);
        }

        parent::__construct($config);
    }

    public function rules() : array
    {
        return [
            ['file_type_id', 'required',],
            ['file_type_id', 'integer'],
        ];
    }

    protected function internalForms(): array
    {
        return [ 'question'];
    }

    public function attributeLabels()
    {
        return [
            'file_type_id' => "Загружаемый тип файла"
        ];
    }

    public function groupFileTypesList()
    {
        return TestQuestionHelper::getAllFileTypes();
    }
}