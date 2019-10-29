<?php


namespace dictionary\forms;


use dictionary\helpers\TemplatesHelper;
use dictionary\models\Templates;
use yii\base\Model;

class TemplatesCreateForm extends Model
{
    public $type_id, $name, $text, $name_for_user;

    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['type_id', 'name', 'text', 'name_for_user'], 'required'],
            ['type_id', 'integer'],
            [['text', 'name', 'name_for_user'], 'string'],
            [['text'], 'unique', 'targetClass' => Templates::class, 'targetAttribute' => ['type_id', 'text']],
            ['type_id', 'in', 'range' => TemplatesHelper::templatesType(), 'allowArray' => true],
        ];
    }

    public function attributeLabels(): array
    {
        return Templates::labels();
    }

    public function typeTemplatesList()
    {
        return TemplatesHelper::typeTemplatesList();
    }
}