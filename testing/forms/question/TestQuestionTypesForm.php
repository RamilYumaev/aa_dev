<?php


namespace testing\forms\question;
use common\auth\forms\CompositeForm;
use testing\models\Answer;
use testing\models\TestQuestion;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;


class TestQuestionTypesForm extends CompositeForm
{
    public $answer;
    public $id;
    private $model;
    private $type;
    public $oldIds;

    public function __construct ($group_id, $type, TestQuestion $question = null, $olympic = null,  $config = [])
    {
        $this->type = $type;
        $this->id = "54789889545665845645645564546546456";
        $this->model = new AnswerForm($this->type);
        if ($question) {
            $this->question = new TestQuestionEditForm($question);
            $modelAll = Answer::find()->where(['quest_id'=>$question->id])->all();
            $this->oldIds = ArrayHelper::map($modelAll, 'id', 'id');
            $this->answer = array_map(function ($answer) { return new AnswerForm($this->type, $answer);
            }, $modelAll);
        } else {
            $this->question = new TestQuestionForm($group_id, $this->type, $olympic);
            $this->answer = [$this->model];
        }
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
                    $this->answer [] = new AnswerForm($this->type, null, $value);
                }
            }
        } catch (InvalidConfigException $e) {
        }
        return $this->answer;
    }
}