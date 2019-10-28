<?php


namespace dictionary\models;


use dictionary\forms\DictDisciplineCreateForm;
use dictionary\forms\DictDisciplineEditForm;

class DictDiscipline extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dict_discipline';
    }

    public static function create(DictDisciplineCreateForm $form)
    {
        $discipline = new static();
        $discipline->name = $form->name;
        $discipline->links = $form->links;
        return $discipline;
    }

    public function edit(DictDisciplineEditForm $form)
    {
        $this->name = $form->name;
        $this->links = $form->links;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название дисциплины',
            'links' => 'Ссылка на сайте',
        ];
    }

    public static function labels(): array
    {
        $discipline = new static();
        return $discipline->attributeLabels();
    }

}