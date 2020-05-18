<?php

namespace dictionary\models;

use dictionary\forms\DictClassEditForm;
use dictionary\forms\DictClassCreateForm;
use dictionary\helpers\DictClassHelper;
use dictionary\models\queries\DictClassQuery;
use yii\db\ActiveRecord;

class DictClass extends ActiveRecord
{

    public static function tableName()
    {
        return 'dict_class';
    }


    public function moderationAttributes($value): array
    {
        return [
            'name' => $value,
            'type' => DictClassHelper::typeName($value)
        ];
    }

    public function titleModeration(): string
    {
        return "Класс";
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
        $name = $this->name ? $this->name . '-й ' : '';
        return $name . DictClassHelper::typeName($this->type);
    }

    public static function find(): DictClassQuery
    {
        return new DictClassQuery(static::class);
    }


}