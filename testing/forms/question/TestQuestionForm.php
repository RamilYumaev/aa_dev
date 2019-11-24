<?php


namespace testing\forms\question;

use testing\helpers\TestQuestionGroupHelper;
use testing\models\TestQuestion;
use yii\base\Model;

class TestQuestionForm extends Model
{
    public $type_id, $title, $text, $group_id;

    public function __construct($group_id, $type, $config = [])
    {
        if ($group_id) {
            $this->group_id = $group_id;
        } else {
            $this->group_id = 0;
        }
        $this->type_id = $type;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['type_id', 'title', 'text'], 'required'],
            ['title', 'unique', 'targetClass' => TestQuestion::class, 'targetAttribute' => ['title', 'text'], 'message' => 'Такой вопрос уже внесен в систему'],
            [['type_id', 'group_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['text'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return TestQuestion::labels();
    }

    public function groupQuestionsList()
    {
        return TestQuestionGroupHelper::testQuestionGroupList();
    }
}