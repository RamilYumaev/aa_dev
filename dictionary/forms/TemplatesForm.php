<?php


namespace dictionary\forms;


use dictionary\helpers\TemplatesHelper;
use dictionary\models\Templates;
use yii\base\Model;

class TemplatesForm extends Model
{
    public $type_id, $name, $text, $name_for_user;

    public function __construct(Templates $templates = null, $config = [])
    {
        if ($templates) {
            $this->type_id = $templates->type_id;
            $this->name = $templates->name;
            $this->name_for_user = $templates->name_for_user;
            $this->text = $templates->text;
        }
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