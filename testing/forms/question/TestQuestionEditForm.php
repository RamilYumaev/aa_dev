<?php


namespace testing\forms\question;

use testing\helpers\TestQuestionGroupHelper;
use testing\models\TestQuestion;
use yii\base\Model;

class TestQuestionEditForm extends Model
{
    public $type_id, $title, $text, $group_id;
    public  $_question;

    public function __construct(TestQuestion $question, $config = [])
    {
        $this->title = $question->title;
        $this->group_id = $question->group_id;
        $this->text = $question->text;
        $this->type_id = $question->type_id;
        $this->_question = $question;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['type_id', 'title', 'text'], 'required'],
            ['title', 'unique', 'targetClass' => TestQuestion::class, 'targetAttribute' => ['title', 'text'],
                'filter'=>['<>', 'id', $this->_question->id],'message' => 'Такой вопрос уже внесен в систему'],
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