<?php


namespace testing\forms\question;
use common\auth\forms\CompositeForm;
use testing\models\AnswerCloze;
use yii\base\InvalidConfigException;


class TestQuestionClozeForm  extends CompositeForm
{
    public $answerCloze;
    public $questProp;
    public $id;
    private $modelQuestProp;
    private $modelAnswerCloze;
    private $type;

    public function __construct ($group_id, $type, $olympic,  $config = [])
    {

        $this->type = $type;
        $this->id = "54789889545665845645645564546546456";

        $this->question = new TestQuestionForm($group_id, $this->type, $olympic);

        $this->modelQuestProp = new QuestionPropositionForm($this->type);
        $this->modelAnswerCloze = new AnswerClozeForm($this->type);

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
            $postData = \Yii::$app->request->post($this->modelQuestProp->formName());
            if ($postData){
                $this->questProp = [];
                foreach ($postData as $value) {
                    $this->questProp [] = new QuestionPropositionForm($this->type, null, $value);
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
                $this->answerCloze  = \Yii::$app->request->post($this->modelAnswerCloze->formName());
                foreach ($this->answerCloze as $index => $answers) {
                    foreach ($answers as $i => $answer) {
                        $data[$this->modelAnswerCloze->formName()] = $answer;
                        $form = new AnswerClozeForm($this->type);
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