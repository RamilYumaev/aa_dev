<?php


namespace testing\forms\question;
use common\auth\forms\CompositeForm;


class TestQuestionTypesForm extends CompositeForm
{
    public $selectAnswer  = [];

    public function __construct ($group_id, $type, $config = [])
    {
        $this->question = new TestQuestionForm($group_id, $type);

        parent::__construct($config);
    }

    public function rules() : array
    {
        return [
            [['selectAnswer'], function($attribute, $params) {
                if (!is_array($this->$attribute)) {
                    $this->addError($attribute, "$attribute isn't an array!");
                }
            }],
        ];
    }

    protected function internalForms(): array
    {
        return [ 'question'];
    }
}