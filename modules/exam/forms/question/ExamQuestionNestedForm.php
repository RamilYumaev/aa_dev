<?php
namespace modules\exam\forms\question;

use modules\exam\models\ExamQuestionNested;
use testing\helpers\TestQuestionHelper;
use yii\base\Model;

class ExamQuestionNestedForm extends Model
{
    public $name, $is_start, $type, $id;

    public function __construct(ExamQuestionNested $questionProposition = null, $config = [])
    {
        if ($questionProposition) {
            $this->id = $questionProposition->id;
            $this->name = $questionProposition->name;
            $this->is_start = $questionProposition->is_start;
            $this->type = $questionProposition->type;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['name', 'required'],
            [['is_start'], 'boolean'],
            [['type'], 'integer'],
            [['name'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return (new ExamQuestionNested())->attributeLabels();
    }

    public function typeList() {
        return TestQuestionHelper::getAllTypeCloze();
    }

    public function getIsNewRecord () {
        return true;
    }
}