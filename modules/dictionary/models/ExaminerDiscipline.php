<?php


namespace modules\dictionary\models;


use dictionary\models\DictDiscipline;
use modules\dictionary\forms\DictExaminerForm;
use modules\dictionary\forms\DictOrganizationForm;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%examiner_discipline}}".
 *
 * @property integer $examiner_id
 * @property integer $discipline_id
 *
 **/


class ExaminerDiscipline extends ActiveRecord
{

    public static function tableName()
    {
        return "{{examiner_discipline}}";
    }

    public static function create($examinerId,  $disciplineId)
    {
        $model = new static();
        $model->examiner_id = $examinerId;
        $model->discipline_id = $disciplineId;
        return $model;
    }

    public function getDiscipline(){
        return $this->hasOne(DictDiscipline::class, ['id'=>'discipline_id']);
    }

    public function attributeLabels()
    {
        return [
            "examiner_id" => "ФИО председателя экзаменационных комиссий",
            "discipline_id" => "Дисциплина",
        ];
    }
}