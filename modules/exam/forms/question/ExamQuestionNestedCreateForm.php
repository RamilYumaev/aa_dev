<?php


namespace modules\exam\forms\question;
use common\auth\forms\CompositeForm;
use modules\dictionary\models\JobEntrant;
use modules\exam\models\ExamAnswerNested;
use modules\exam\models\ExamQuestion;
use modules\exam\models\ExamQuestionGroup;
use testing\helpers\TestQuestionHelper;
use testing\models\AnswerCloze;
use yii\base\InvalidConfigException;


class ExamQuestionNestedCreateForm extends CompositeForm
{
    public $answerCloze;
    public $questProp;
    public $id;
    private $modelQuestProp;
    private $modelAnswerCloze;

    public function __construct (JobEntrant $jobEntrant, $config = [])
    {
        $this->id = "54789889545665845645645564546546456";

        $this->question = new ExamQuestionForm($jobEntrant, null, ['type_id'=> TestQuestionHelper::TYPE_CLOZE ]);

        $this->modelQuestProp = new ExamQuestionNestedForm();
        $this->modelAnswerCloze = new ExamAnswerNestedForm();

        $this->questProp = [$this->modelQuestProp];
        $this->answerCloze = [[$this->modelAnswerCloze]];

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
                $this->answerCloze  = \Yii::$app->request->post('ExamAnswerNestedForm');
                foreach ($this->answerCloze as $index => $answers) {
                    foreach ($answers as $i => $answer) {
                        $data[$this->modelAnswerCloze->formName()] = $answer;
                        $form = new ExamAnswerNestedForm();
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