<?php


namespace modules\exam\forms\question;
use common\auth\forms\CompositeForm;
use modules\dictionary\models\JobEntrant;
use modules\exam\models\ExamAnswer;
use modules\exam\models\ExamQuestion;

use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;


class ExamTypeQuestionAnswerForm extends CompositeForm
{
    public $answer;
    public $id;
    public $type;
    private $model;
    public $oldIds;

    public function __construct (JobEntrant $jobEntrant, ExamQuestion $question = null, $type=null, $config = [])
    {
        $this->id = "54789889545665845645645564546546456";
        if ($question) {
            $this->question = new ExamQuestionForm($jobEntrant, $question);
            $this->type = $question->type_id;
            $modelAll = ExamAnswer::find()->where(['question_id'=>$question->id])->all();
            $this->oldIds = ArrayHelper::map($modelAll, 'id', 'id');
            $this->answer = array_map(function ($answer) {
                return new ExamAnswerForm($answer, ['type' => $this->type]);
            }, $modelAll);
        } else {
            $this->type = $type;
            $this->model = new ExamAnswerForm(null, ['type' => $type]);
            $this->question = new ExamQuestionForm($jobEntrant, null, ['type_id'=> $type]);
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
            $postData = \Yii::$app->request->post('ExamAnswerForm');
            if ($postData){
                $this->answer = [];
                foreach ($postData as $value) {
                    $this->answer [] = new ExamAnswerForm(null, $value);
                }
            }
        } catch (InvalidConfigException $e) {
        }
        return $this->answer;
    }
}