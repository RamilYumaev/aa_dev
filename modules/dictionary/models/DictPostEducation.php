<?php


namespace modules\dictionary\models;

use modules\dictionary\forms\DictPostEducationForm;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%dict_post_education}}".
 *
 * @property integer $id
 * @property string $name
 *
**/

class DictPostEducation extends ActiveRecord
{

    public static  function create(DictPostEducationForm $form) {
        $dictPostEducation =  new static();
        $dictPostEducation->data($form);
        return $dictPostEducation;
    }

    public function data(DictPostEducationForm $form)
    {
        $this->name = $form->name;
    }

    public static function tableName()
    {
        return "{{%dict_post_education}}";
    }

    public function attributeLabels()
    {
        return [
            'name'=>'Наименование',
        ];
    }

}