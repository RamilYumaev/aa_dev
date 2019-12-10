<?php

namespace testing\models;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\FileUploadBehavior;

class TestResult extends ActiveRecord
{


    public static function tableName()
    {
        return 'test_result';
    }

    public static function create($attempt_id, $question_id, $priority, $tq_id) {
        $result = new static();
        $result->attempt_id =$attempt_id;
        $result->question_id = $question_id;
        $result->priority = $priority;
        $result->result = null;
        $result->tq_id = $tq_id;
        return $result;
    }

    public function setFile(UploadedFile $file): void
    {
        $this->result = $file;
    }

    public function edit($result, $mark) {
        $this->updated = date("Y-m-d H:i:s");
        $this->result = $result;
        $this->mark = $mark;
    }

    public function getPath() {
        return $this->attempt_id."/".$this->tq_id."/". $this->question_id;
    }

    public function attributeLabels()
    {
        return [
            'attempt_id' => 'Попытка',
            'question_id' => 'Вопрос',
            'updated' => 'Обновление',
            'result' => 'Результат',
            'mark' => 'Оценка',
            'resultFile' => 'Файл с ответом',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => FileUploadBehavior::class,
                'attribute' => 'result',
                'filePath' => '@staticRoot/origin/result/[[attribute_question_id]].[[extension]]',
                'fileUrl' => '@static/origin/result/[[attribute_question_id]].[[extension]]',
            ],
        ];
    }

}