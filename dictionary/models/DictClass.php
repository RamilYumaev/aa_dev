<?php

namespace dictionary\models;

use dictionary\forms\DictClassEditForm;
use dictionary\forms\DictClassCreateForm;
use dictionary\helpers\DictClassHelper;
use dictionary\models\queries\DictClassQuery;
use dictionary\models\queries\DictCompetitiveGroupQuery;

class DictClass extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'dict_class';
    }

    public static function create(DictClassCreateForm $form): self
    {
        $class = new static();
        $class->name = $form->name;
        $class->type = $form->type;
        return $class;
    }


    public function edit(DictClassEditForm $form): void
    {
        $this->name = $form->name;
        $this->type = $form->type;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'name' => 'Номер',
            'type' => 'Тип',
        ];
    }

    public static function labels(): array
    {
        $class = new static();
        return $class->attributeLabels();
    }

    public function getClassFullName(): string
    {
        $type = DictClassHelper::typeOfClass();
        return $this->name . '-й ' . $type[$this->type];
    }

    public static function find(): DictClassQuery
    {
        return new DictClassQuery(static::class);
    }
}