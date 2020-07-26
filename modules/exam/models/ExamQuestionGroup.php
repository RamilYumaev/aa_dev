<?php

namespace modules\exam\models;

use dictionary\models\DictDiscipline;
use modules\exam\forms\ExamQuestionGroupForm;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%exam_question_group}}".
 *
 * @property integer $id
 * @property integer $discipline_id
 * @property  string $name
 **/


class ExamQuestionGroup extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%exam_question_group}}';
    }

    public static function create(ExamQuestionGroupForm $form)
    {
        $exam = new static();
        $exam->data($form);
        return $exam;
    }

    public function data(ExamQuestionGroupForm $form) {
        $this->name = $form->name;
        $this->discipline_id = $form->discipline_id;
    }

    public function getDiscipline(){
        return $this->hasOne(DictDiscipline::class, ['id'=>'discipline_id']);
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название группы',
            'discipline_id'=> 'Вступительное испытание'
        ];
    }

}