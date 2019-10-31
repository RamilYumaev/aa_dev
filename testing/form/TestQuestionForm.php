<?php


namespace testing\forms;


use tests\helpers\TestQuestionGroupHelper;
use tests\helpers\TestQuestionHelper;
use tests\models\TestQuestion;
use yii\base\Model;

class TestQuestionForm extends Model
{
    public $type_id, $title, $mark, $text, $file_type_id, $options, $group_id, $optionsArray;

    public function __construct(TestQuestion $testQuestion = null, $config = [])
    {
        if ($testQuestion) {
            $this->type_id = $testQuestion->type_id;
            $this->title = $testQuestion->title;
            $this->mark = $testQuestion->mark;
            $this->text = $testQuestion->text;
            $this->file_type_id = $testQuestion->file_type_id;
            $this->options = $testQuestion->options;
            $this->group_id = $testQuestion->group_id;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['type_id', 'title', 'mark', 'text'], 'required'],
            ['title', 'unique', 'targetClass' => TestQuestion::class, 'targetAttribute' => ['title', 'text'], 'message' => 'Такой вопрос уже внесен в систему'],

            ['file_type_id', 'required', 'when' => function ($model) {
                /** @var self $model */
                return $model->type_id == TestQuestionHelper::TYPE_FILE;
            },
                'whenClient' =>
                    'function (attribute, value) {return $("#testquestion-type_id").val() == ' .
                    TestQuestionHelper::TYPE_FILE . ';}'],
            ['optionsArray', 'required', 'when' => function ($model) {
                /** @var self $model */
                return $model->type_id == TestQuestionHelper::TYPE_SELECT ||
                    $model->type_id == TestQuestionHelper::TYPE_SELECT_ONE ||
                    $model->type_id == TestQuestionHelper::TYPE_MATCHING ||
                    $model->type_id == TestQuestionHelper::TYPE_ANSWER_SHORT;
            },
                'whenClient' =>
                    'function (attribute, value) {var typeId = $("#testquestion-type_id").val(); return ' .
                    'typeId == ' . TestQuestionHelper::TYPE_SELECT . ' || ' .
                    'typeId == ' . TestQuestionHelper::TYPE_SELECT_ONE . ' || ' .
                    'typeId == ' . TestQuestionHelper::TYPE_MATCHING . ' || ' .
                    'typeId == ' . TestQuestionHelper::TYPE_ANSWER_SHORT . ';}'],

            [['type_id', 'file_type_id', 'test_id', 'group_id'], 'integer'],
            [['mark'], 'number', 'max' => 100, 'min' => 0.1, 'numberPattern' => '/^\d{1,3}(\.\d)?$/'],
            [['options'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['text'], 'string'],
            ['optionsArray', 'validateOptionsArray'],
            ['type_id', 'in', 'range' => TestQuestionHelper::allTypesVlid(), 'allowArray' => true],
            ['file_type_id', 'in', 'range' => TestQuestionHelper::allFileTypesValid(), 'allowArray' => true],
        ];
    }

    public function validateOptionsArray($attribute, $params)
    {
        if ($this->hasErrors()) {
            return;
        }

        if ($this->type_id == TestQuestionHelper::TYPE_ANSWER_SHORT) {
            if (\count(\array_filter($this->{$attribute})) === 0) {
                $this->addError(
                    $attribute,
                    'Необходимо указать правильные ответы.'
                );
            }
        }

        if ($this->type_id == TestQuestionHelper::TYPE_SELECT || $this->type_id == TestQuestionHelper::TYPE_SELECT_ONE) {
            if (!isset($this->{$attribute}['isCorrect'])) {
                $this->addError(
                    $attribute,
                    'Необходимо указать правильные ответы.'
                );
                return;
            }

            foreach ($this->{$attribute}['isCorrect'] as $correctIndex) {
                if ($this->{$attribute}['text'][$correctIndex] === '') {
                    $this->addError(
                        $attribute,
                        'Правильный ответ не должен быть пустым.'
                    );
                    return;
                }
            }
        }

        if ($this->type_id == TestQuestionHelper::TYPE_SELECT) {
            if (\count($this->{$attribute}['isCorrect']) !== \count(\array_filter($this->{$attribute}['text'])) / 2) {
                $this->addError(
                    $attribute,
                    'Необходимо чтобы количество правильных ответов было равно количеству неправильных ответов.'
                );
            }
            return;
        }
    }

    public function attributeLabels()
    {

        return TestQuestion::labels();
    }

    public function testQuestionGroupList(): array
    {
        return TestQuestionGroupHelper::testQuestionGroupList();
    }

    public function getAllTypes(): array
    {
        return TestQuestionHelper::getAllTypes();
    }

    public function getAllFileTypes(): array
    {
        return TestQuestionHelper::getAllFileTypes();
    }

}