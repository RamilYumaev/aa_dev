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

class DictCtSubject extends DictCseSubject
{
    public static function tableName()
    {
        return "{{%dict_ct_subject}}";
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Наименование',
            'min_mark' => "Минимальный балл для поступления",
            'composite_discipline_status'=>'Составная дисциплина',
            'cse_status'=>'Предмет ЦТ',
            'ais_id'=>'Id АИС ВУЗ',
        ];
    }
}