<?php


namespace modules\dictionary\models;



use modules\dictionary\forms\DictCathedraForm;
use modules\dictionary\forms\DictCseSubjectForm;
use modules\dictionary\helpers\DictDefaultHelper;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%dict_cathedra}}".
 *
 * @property integer $id
 * @property string $name
 *
 **/

class DictCathedra extends ActiveRecord
{

    public static function create(DictCathedraForm $form)
    {
        $dictPostEducation = new static();
        $dictPostEducation->data($form);
        return $dictPostEducation;
    }

    public function data(DictCathedraForm $form)
    {
        $this->name = $form->name;
    }

    public static function tableName()
    {
        return "{{%dict_cathedra}}";
    }


    public function attributeLabels()
    {
        return [
            'name' => 'Наименование',
        ];
    }
}