<?php


namespace modules\exam\models;

use dictionary\models\DictDiscipline;
use modules\exam\forms\question\ExamQuestionForm;
use modules\exam\forms\question\ExamQuestionNestedUpdateForm;
use modules\exam\helpers\ExamQuestionHelper;
use testing\forms\question\TestQuestionForm;
use testing\forms\question\TestQuestionEditForm;
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
        $this->file_type_id = null;
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
            'discipline_id' => "Дисциплина",
            'type' => 'Тип вопроса',
        ];
    }

    public function getAnswer () {
        return $this->hasMany(ExamAnswer::class, ['question_id' => "id"]);
    }

    public function getAnswerCorrect () {
        return $this->getAnswer()->andWhere( ['is_correct' => true]);
    }

    public function getAnswerUser ($ids) {
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