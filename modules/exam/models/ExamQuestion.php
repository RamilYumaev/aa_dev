<?php


namespace modules\exam\models;

use dictionary\models\DictDiscipline;
use modules\exam\forms\question\ExamQuestionForm;
use modules\exam\helpers\ExamQuestionHelper;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%exam_question}}".
 *
 * @property integer $id
 * @property integer $question_group_id
 * @property integer $discipline_id
 * @property integer $type_id
 * @property string $title
 * @property string $text
 * @property integer $file_type_id
 *
 **/

class ExamQuestion extends ActiveRecord
{

    public static function create(ExamQuestionForm $form)
    {
        $question = new static();
        $question->data($form);
        return $question;
    }

    public function data(ExamQuestionForm $form)
    {
        $this->title = $form->title;
        $this->type_id = $form->type_id;
        $this->text = $form->text;
        $this->file_type_id = $form->file_type_id;
        $this->discipline_id = $form->discipline_id;
        $this->question_group_id = $form->question_group_id;
    }


    public static function tableName()
    {
        return '{{%exam_question}}';
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question_group_id' => 'Группа вопросов',
            'type_id' => 'Тип вопроса',
            'title' => 'Заголовок',
            'text' => 'Вопрос',
            'file_type_id' => 'Загружаемый тип файла',
            'discipline_id' => "Вступительное испытание",
            'type' => 'Тип вопроса',
        ];
    }

    public function isNestedType() {
        return $this->type_id == ExamQuestionHelper::TYPE_CLOZE;
    }

    public function getAnswer () {
        return $this->hasMany(ExamAnswer::class, ['question_id' => "id"]);
    }

    public function getQuestionNested () {
        return $this->hasMany(ExamQuestionNested::class, ['question_id' => "id"]);
    }

    public function getAnswerCorrect () {
        return $this->getAnswer()->andWhere( ['is_correct' => true]);
    }

    public function getCorrectAnswer(){
        switch ($this->type_id):
            case ExamQuestionHelper::TYPE_SELECT:
                $answer = ['select'=>$this->getAnswerCorrect()->select('id')->column()];
                break;
            case ExamQuestionHelper::TYPE_SELECT_ONE:
                $answer = ['select-one'=> $this->getAnswerCorrect()->select('id')->one() ? $this->getAnswerCorrect()->select('id')->one()->id : "" ];
                break;
            case ExamQuestionHelper::TYPE_MATCHING:
                $answer = ['matching' => $this->getAnswerCorrect()->select( ['answer_match','id'])->indexBy('id')->column()];
                break;
            case ExamQuestionHelper::TYPE_ANSWER_SHORT:
                $answer = ['short'=> $this->getAnswerCorrect()->select('id')->one() ? $this->getAnswerCorrect()->select('name')->one()->name : "" ];
                break;
            case ExamQuestionHelper::TYPE_ANSWER_DETAILED:
                $answer = "";
                break;
            case ExamQuestionHelper::TYPE_FILE:
                $answer = null;
                break;
            default:
                $ids = $this->getQuestionNested()->andWhere(['type'=>1])->select('id')->column();
                $anw = ExamAnswerNested::find()->select(['name','question_nested_id'])->andWhere(['is_correct'=> true, 'question_nested_id'=> $ids  ])->indexBy('question_nested_id')->column();
                $data=['select-cloze'=>$anw];
                $answer = $data['select-cloze'] ? $data : null;
        endswitch;
        return $answer;
    }

    public function getAnswerUser($ids) {
        return $this->getAnswer()->andWhere(['id' =>$ids]);
    }

    public function getQuestionGroup(){
        return $this->hasOne(ExamQuestionGroup::class, ['id'=>'question_group_id']);
    }


    public function getDiscipline(){
        return $this->hasOne(DictDiscipline::class, ['id'=>'discipline_id']);
    }

    public function getTypeName(){
        return ExamQuestionHelper::typeName($this->type_id);
    }

    public static function labels()
    {
        $testQue = new static();
        return $testQue->attributeLabels();
    }
}