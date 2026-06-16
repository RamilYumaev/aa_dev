<?php


namespace testing\models;

use testing\forms\question\TestQuestionForm;
use testing\forms\question\TestQuestionEditForm;
use testing\helpers\TestQuestionHelper;
use yii\db\ActiveRecord;

class TestQuestion extends ActiveRecord
{

    public static function create(TestQuestionForm $form, $group_id, $file_type_id, $options, $olympic_id)
    {
        $testQue = new static();
        $testQue->type_id = $form->type_id;
        $testQue->title = $form->title;
        $testQue->mark = null;
        $testQue->text = $form->text;
        $testQue->file_type_id = $file_type_id ?? null;
        $testQue->options = $options;
        $testQue->group_id = $group_id;
        $testQue->olympic_id = $olympic_id;
        return $testQue;
    }

    public function edit(TestQuestionEditForm $form,  $group_id, $file_type_id)
    {
        $this->title = $form->title;
        $this->text = $form->text;
        $this->file_type_id = $file_type_id ?? null;
        $this->group_id = $group_id;
    }


    public static function tableName()
    {
        return 'test_question';
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group_id' => 'Группа вопросов',
            'type_id' => 'Тип вопроса',
            'title' => 'Заголовок',
            'text' => 'Вопрос',
            'mark' => 'Сумма первичных баллов',
            'options' => 'Варианты',
            'file_type_id' => 'Загружаемый тип файла',
            'type' => 'Тип вопроса',
            'optionsArray' => 'Варианты',
        ];
    }

    public function getAnswer () {
        return $this->hasMany(Answer::class, ['quest_id' => "id"]);
    }

    public function getQuestionNested() {
        return $this->hasMany(QuestionProposition::class, ['quest_id' => "id"]);
    }

    public function getAnswerCorrect () {
        return $this->getAnswer()->andWhere( ['is_correct' => true]);
    }

    public function isNestedType() {
        return $this->type_id == TestQuestionHelper::TYPE_CLOZE;
    }

    public function getCorrectAnswer(){
        switch ($this->type_id):
            case TestQuestionHelper::TYPE_SELECT:
                $answer = ['select'=> $this->getAnswerCorrect()->select('id')->column()];
                break;
            case TestQuestionHelper::TYPE_SELECT_ONE:
                $answer = ['select-one'=> $this->getAnswerCorrect()->select('id')->one() ? $this->getAnswerCorrect()->select('id')->one()->id : "" ];
                break;
            case TestQuestionHelper::TYPE_MATCHING:
                $answer = ['matching' => $this->getAnswerCorrect()->select( ['answer_match','id'])->indexBy('id')->column()];
                break;
            case TestQuestionHelper::TYPE_ANSWER_SHORT:
                $answer = ['short'=> $this->getAnswerCorrect()->select('id')->one() ? $this->getAnswerCorrect()->select('name')->one()->name : "" ];
                break;
            case TestQuestionHelper::TYPE_ANSWER_DETAILED:
                $answer = "";
                break;
            case TestQuestionHelper::TYPE_URL:
            case TestQuestionHelper::TYPE_FILE:
                $answer = null;
                break;
            default:
                $ids = $this->getQuestionNested()->andWhere(['type'=>1])->select('id')->column();
                $anw = AnswerCloze::find()->select(['name','quest_prop_id'])->andWhere(['is_correct'=> true, 'quest_prop_id'=> $ids  ])->indexBy('quest_prop_id')->column();
                $data=['select-cloze'=>$anw];
                $answer = $data['select-cloze'] ? $data : null;
        endswitch;
        return $answer;
    }

    public function getAnswerUser ($ids) {
        return $this->getAnswer()->andWhere(['id' =>$ids]);
    }


    public static function labels()
    {
        $testQue = new static();
        return $testQue->attributeLabels();
    }




}