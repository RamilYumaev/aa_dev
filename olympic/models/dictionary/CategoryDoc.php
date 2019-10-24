<?php


namespace olympic\models\dictionary;


use olympic\forms\dictionary\CategoryDocForm;

class CategoryDoc extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public static function tableName()
    {
        return 'dict_category_doc';
    }

    public static function create (CategoryDocForm $form) : self
    {
        $categoryDoc =  new static();
        $categoryDoc->name = $form->name;
        $categoryDoc->type_id = $form->type_id;
        return $categoryDoc;
    }

    public function edit(CategoryDocForm $form) :void
    {
        $this->name = $form->name;
        $this->type_id = $form->type_id;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ИД',
            'name' => 'Название категории',
            'type_id' => 'Тип категории',
        ];
    }

    public static function labels(): array
    {
        $categoryDoc =  new static();
        return $categoryDoc->attributeLabels();
    }

}