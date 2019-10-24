<?php


namespace backend\models\dictionary;


class CategoryDoc extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    const TYPELINK = 1;
    const TYPEDOC = 2;

    public static function tableName()
    {
        return 'dict_category_doc';
    }

    public static function create (string $name, int  $type_id) : self
    {
        $catDoc =  new static();
        $catDoc->name = $name;
        $catDoc->type_id = $type_id;
        return $catDoc;
    }

    public function edit(string $name, int  $type_id) :void
    {
        $this->name = $name;
        $this->type_id = $type_id;
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
        $catDoc =  new static();
        return $catDoc->attributeLabels();
    }

}