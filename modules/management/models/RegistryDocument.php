<?php


namespace modules\management\models;

use modules\management\forms\DictTaskForm;
use modules\management\forms\RegistryDocumentForm;
use modules\management\models\queries\DictTaskQuery;
use yii\db\ActiveRecord;

/**
 * @property $name string
 * @property $link string
 * @property $category_document_id integer
 * @property $id integer
 */
class RegistryDocument extends ActiveRecord
{

    public static function tableName()
    {
        return "{{registry_document}}";
    }

    public static function create(RegistryDocumentForm $form)
    {
        $model = new static();
        $model->data($form);
        return $model;
    }

    public function data(RegistryDocumentForm $form)
    {
        $this->name = $form->name;
        $this->link = $form->link;
        $this->category_document_id = $form->category_document_id;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ИД',
            'name' => 'Наименование',
            'category_document_id' => 'Категория',
            'link' => 'Ссылка'
         ];
    }

    public function getCategoryDocument()
    {
        return $this->hasOne(CategoryDocument::class, ['id'=> 'category_document_id']);
    }
}