<?php


namespace dictionary\forms;


use common\helpers\EduYearHelper;
use dictionary\helpers\TemplatesHelper;
use dictionary\models\Templates;
use yii\base\Model;

class TemplatesCopyForm extends Model
{
    public $type_id, $name, $text, $name_for_user, $year;

    public function __construct(Templates $templates, $config = [])
    {
        $this->type_id = $templates->type_id;
        $this->name = $templates->name;
        $this->name_for_user = $templates->name_for_user;
        $this->text = $templates->text;
        $this->year = $templates->year;

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['type_id', 'name', 'text', 'name_for_user', 'year'], 'required'],
            ['type_id', 'integer'],
            [['text', 'name', 'name_for_user'], 'string'],
            [['text'], 'unique', 'targetClass' => Templates::class, 'targetAttribute' => ['type_id', 'text', 'year']],
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

    public function years(): array
    {
        return EduYearHelper::eduYearList();
    }

}