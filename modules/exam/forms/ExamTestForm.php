<?php

namespace modules\exam\forms;

use modules\exam\models\ExamTest;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class ExamTestForm extends Model
{
    public $exam_id,
        $name,
        $introduction,
        $final_review,
         $random_order;
    private $_exam_test;


    public function __construct(ExamTest $examTest = null, $config = [])
    {
        if($examTest){
            $this->setAttributes($examTest->getAttributes(), false);
            $this->_exam_test = $examTest;
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */

    public function defaultRules()
    {
        return [
            [['name'], 'required'],
            [['exam_id', 'random_order'], 'integer'],
            [['introduction', 'final_review'], 'string'],
            [['name'], 'string', 'max'=>255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function uniqueRules()
    {
        $arrayUnique = [['name'], 'unique', 'targetClass' => ExamTest::class,
            'targetAttribute' => ['exam_id', 'name'], 'message'=>'Вы уже добавили'];
        if ($this->_exam_test) {
            return ArrayHelper::merge($arrayUnique,['filter' => ['<>', 'id', $this->_exam_test->id]]);
        }
        return $arrayUnique;
    }

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return ArrayHelper::merge($this->defaultRules(), [$this->uniqueRules()]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return (new ExamTest())->attributeLabels();
    }

}