<?php


namespace modules\dictionary\models;


use modules\dictionary\forms\DictExaminerForm;
use modules\dictionary\forms\DictOrganizationForm;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%dict_examiner}}".
 *
 * @property integer $id
 * @property string $fio
 *
 **/


class DictExaminer extends ActiveRecord
{

    public static function tableName()
    {
        return "{{dict_examiner}}";
    }


    public static function create(DictExaminerForm $form)
    {
        $model = new static();
        $model->data($form);
        return $model;
    }

    public function data(DictExaminerForm $form)
    {
        $this->fio = $form->fio;
    }

    public function getDisciplineExaminer() {
        return $this->hasMany(ExaminerDiscipline::class, ['examiner_id' => 'id']);
    }

    public function  getDisciplineColumn(){
        return $this->getDisciplineExaminer()->select(['discipline_id'])->column();
    }

    public function attributeLabels()
    {
        return [
            "fio" => "ФИО председателя экзаменационных комиссий",
        ];
    }
}