<?php


namespace testing\forms\question;
use common\auth\forms\CompositeForm;
use yii\base\InvalidConfigException;


class TestQuestionTypesForm extends CompositeForm
{
    public $answer;
    public $id;
    private $model;
    private $type;

    public function __construct ($group_id, $type, $config = [])
    {
        $this->type = $type;
        $this->id = "54789889545665845645645564546546456";
        $this->model = new AnswerForm($this->type);
        $this->question = new TestQuestionForm($group_id, $this->type);
        $this->answer = [$this->model];
        parent::__construct($config);
    }

    public function rules() : array
    {
        return [
            [['id'], 'string'],
        ];
    }

    protected function internalForms(): array
    {
        return [ 'question'];
    }

    public function isArrayMoreAnswer() {
        try {
            $postData = \Yii::$app->request->post($this->model->formName());
            if ($postData){
                $this->answer = [];
                foreach ($postData as $value) {
                    $this->answer [] = new AnswerForm($this->type, $value);
                }
            }
        } catch (InvalidConfigException $e) {
        }
        return $this->answer;
    }
}