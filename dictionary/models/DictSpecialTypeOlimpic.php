<?php


namespace dictionary\models;


use dictionary\forms\DictSpecialTypeOlimpicForm;
use yii\db\ActiveRecord;

class DictSpecialTypeOlimpic extends ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dict_special_type_olimpic';
    }

    public static function create (DictSpecialTypeOlimpicForm $form) : self
    {
        $specialTypeOlimpic =  new static();
        $specialTypeOlimpic->name = $form->name;
        return $specialTypeOlimpic;
    }

    public function edit(DictSpecialTypeOlimpicForm $form) :void
    {
        $this->name = $form->name;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название вида',
        ];
    }

    public static function labels(): array
    {
        $specialTypeOlimpic = new static();
        return $specialTypeOlimpic->attributeLabels();
    }



}