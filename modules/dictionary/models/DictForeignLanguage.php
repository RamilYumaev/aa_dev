<?php


namespace modules\dictionary\models;

use modules\dictionary\forms\DictForeignLanguageForm;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%dict_foreign_language}}".
 *
 * @property integer $id
 * @property string $name
 *
 **/

class DictForeignLanguage extends ActiveRecord
{

    public static function create(DictForeignLanguageForm $form)
    {
        $dictPostEducation = new static();
        $dictPostEducation->data($form);
        return $dictPostEducation;
    }

    public function data(DictForeignLanguageForm $form)
    {
        $this->name = $form->name;
    }

    public static function tableName()
    {
        return "{{%dict_foreign_language}}";
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Наименование',
        ];
    }
}