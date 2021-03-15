<?php


namespace modules\management\models;

use modules\management\forms\CategoryDocumentForm;
use modules\management\forms\DictTaskForm;
use modules\management\models\queries\CategoryDocumentQuery;
use modules\management\models\queries\DictTaskQuery;
use yii\db\ActiveRecord;

/**
 * @property $name string
 * @property $id integer
 */
class CategoryDocument extends ActiveRecord
{

    public static function tableName()
    {
        return "{{category_document}}";
    }

    public static function create(CategoryDocumentForm $form)
    {
        $model = new static();
        $model->data($form);
        return $model;
    }

    public function data(CategoryDocumentForm $form)
    {
        $this->name = $form->name;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ИД',
            'name' => 'Наименование',
        ];
    }

    public static function find(): CategoryDocumentQuery
    {
        return new CategoryDocumentQuery(static::class);
    }
}