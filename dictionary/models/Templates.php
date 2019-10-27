<?php


namespace dictionary\models;

use dictionary\forms\TemplatesForm;
use yii\db\ActiveRecord;

class Templates extends ActiveRecord
{
    public static function tableName()
    {
        return 'templates';
    }

    public static function create(TemplatesForm $form)
    {
        $templates = new static();
        $templates->type_id = $form->type_id;
        $templates->name = $form->name;
        $templates->name_for_user = $form->name_for_user;
        $templates->text = $form->text;
        return $templates;
    }

    public function edit(TemplatesForm $form)
    {
        $this->type_id = $form->type_id;
        $this->name = $form->name;
        $this->name_for_user = $form->name_for_user;
        $this->text = $form->text;
    }


    public function attributeLabels()
    {
        return [
            'type_id' => 'Тип шаблона',
            'name' => 'Название шаблона',
            'text' => 'Текст шаблона',
            'name_for_user' => 'Название для отображения на сайте',

        ];
    }

    public static function labels(): array
    {
        $templates = new static();
        return $templates->attributeLabels();
    }
}