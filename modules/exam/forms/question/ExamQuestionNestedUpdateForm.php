<?php


namespace modules\exam\forms\question;
use common\auth\forms\CompositeForm;
use modules\dictionary\models\JobEntrant;
use modules\exam\models\ExamAnswerNested;
use modules\exam\models\ExamQuestion;
use modules\exam\models\ExamQuestionNested;
use testing\models\AnswerCloze;
use testing\models\QuestionProposition;
use testing\models\TestQuestion;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;


class ExamQuestionNestedUpdateForm extends CompositeForm
{
    public $answerCloze;
    public $questProp;
    public $id;
    private $modelQuestProp;
    public $oldQuestionPropIds;
    public $oldAnswerClozeIds;
    private $modelAnswerCloze;
    public  $oldAnswer;
    private $type;
    public $answerClozeIds;

    public function __construct (JobEntrant $jobEntrant, ExamQuestion $question, $config = [])
    {
        $this->id = "54789889545665845645645564546546456";

        $this->question = new ExamQuestionForm($jobEntrant, $question);

        $modelAll = ExamQuestionNested::find()->where(['question_id'=>$question->id])->all();
        $this->oldQuestionPropIds = ArrayHelper::map($modelAll, 'id', 'id');
        $this->questProp = array_map(function ($quest) { return new ExamQuestionNestedForm($quest);
        }, $modelAll);

        $this->oldAnswer = [];

        if (!empty($modelAll)) {
            foreach ($modelAll as $index => $queProp) {
                $answerClozeAll = ExamAnswerNested::find()->where(['question_nested_id'=> $queProp->id])->all();
                if ($answerClozeAll) {
                $this->answerCloze[$index] = array_map(function ($answer) {
                    return new ExamAnswerNestedForm($answer);
                }, $answerClozeAll);
                $this->oldAnswer = ArrayHelper::merge(ArrayHelper::index($answerClozeAll, 'id'), $this->oldAnswer);
            } else {
                    $this->answerCloze[$index] =[new ExamAnswerNestedForm()];
                }
            }
        }
        $this->oldAnswerClozeIds = ArrayHelper::getColumn($this->oldAnswer, 'id');
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

    public function questPropMore() {

        try {
            $postData = \Yii::$app->request->post('ExamQuestionNestedForm');
            if ($postData){
                $this->questProp = [];
                foreach ($postData as $value) {
                    $this->questProp [] = new ExamQuestionNestedForm(null, $value);
                }
            }
        } catch (InvalidConfigException $e) {
        }
        return $this->questProp;
    }

    public function answerClozeMore() {
        $this->answerCloze = [];
        $valid = true;
            try {
                $this->answerClozeIds = [];
                $this->answerCloze  = \Yii::$app->request->post('ExamAnswerNestedForm');
                foreach ($this->answerCloze as $index => $answers) {
                    $this->answerClozeIds = ArrayHelper::merge($this->answerClozeIds , array_filter(ArrayHelper::getColumn($answers, 'id')));
                    foreach ($answers as $i => $answer) {
                        $data['AnswerClozeForm'] = $answer;
                        $form = (isset($answer['id']) && isset($this->oldAnswer[$answer['id']])) ? $this->oldAnswer[$answer['id']] : new ExamAnswerNestedForm();
                        $form->load($data);
                        $this->answerCloze[$index][$i] = $form;
                        $valid = $form->validate();
                    }
                }

            } catch (InvalidConfigException $e) {
            }
        return $valid ? $this->answerCloze : false;
    }
}