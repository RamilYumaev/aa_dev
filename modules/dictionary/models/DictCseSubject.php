<?php


namespace modules\dictionary\models;
use modules\dictionary\forms\DictCseSubjectForm;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use modules\dictionary\helpers\DictDefaultHelper;


/**
 * This is the model class for table "{{%dict_cse_subject}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $min_mark
 * @property integer $composite_discipline_status
 * @property integer $cse_status
 * @property integer $ais_id
 *
 **/

class DictCseSubject extends ActiveRecord
{

    public static function create(DictCseSubjectForm $form)
    {
        $dictPostEducation = new static();
        $dictPostEducation->data($form);
        return $dictPostEducation;
    }

    public function data(DictCseSubjectForm $form)
    {
        $this->name = $form->name;
        $this->composite_discipline_status =  $form->composite_discipline_status;
        $this->min_mark = $form->min_mark;
        $this->cse_status = $form->cse_status;
        $this->ais_id = $form->ais_id;
    }

    public static function tableName()
    {
        return "{{%dict_cse_subject}}";
    }

    public function getCseStatus() {
        return DictDefaultHelper::name($this->cse_status);
    }

    public function getCompositeDisciplineStatus() {
        return DictDefaultHelper::name($this->composite_discipline_status);
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Наименование',
            'min_mark' => "Минимальный балл для поступления",
            'composite_discipline_status'=>'Составная дисциплина',
            'cse_status'=>'Предмет ЕГЭ',
            'ais_id'=>'Id АИС ВУЗ',
        ];
    }
}