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

<<<<<<< HEAD:backend/models/dictionary/CategoryDoc.php
    public static function create(string $name, int $type_id): self
    {
        $catDoc = new static();
        $catDoc->name = $name;
        $catDoc->type_id = $type_id;
        return $catDoc;
    }

    public function edit(string $name, int $type_id): void
=======
    public static function create (CategoryDocForm $form) : self
    {
        $categoryDoc =  new static();
        $categoryDoc->name = $form->name;
        $categoryDoc->type_id = $form->type_id;
        return $categoryDoc;
    }

    public function edit(CategoryDocForm $form) :void
>>>>>>> #10:olympic/models/dictionary/CategoryDoc.php
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
<<<<<<< HEAD:backend/models/dictionary/CategoryDoc.php
        $catDoc = new static();
        return $catDoc->attributeLabels();
=======
        $categoryDoc =  new static();
        return $categoryDoc->attributeLabels();
>>>>>>> #10:olympic/models/dictionary/CategoryDoc.php
    }

}