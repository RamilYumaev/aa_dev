<?php

namespace modules\exam\models;

use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\FileUploadBehavior;

/**
 * This is the model class for table "{{%exam_result}}".
 *
 * @property integer $id
 * @property integer $question_id
 * @property integer $tq_id
 * @property integer $attempt_id
 * @property integer $mark
 * @property integer $priority
 * @property string $updated
 * @property string $result
 * @property  string $note
 *
 **/
class ExamResult extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%exam_result}}';
    }

    public static function create($attempt_id, $question_id, $priority, $tq_id)
    {
        $result = new static();
        $result->attempt_id = $attempt_id;
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

    public function setMark($mark, $note): void
    {
        $this->mark = $mark;
        $this->note = $note;
    }

    public function edit($result, $mark)
    {
        $this->updated = date("Y-m-d H:i:s");
        $this->result = $result;
        $this->mark = $mark;
    }

    public function getPath()
    {
        return $this->attempt_id . "/" . $this->tq_id . "/" . $this->question_id;
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

    public function getQuestion()
    {
        return $this->hasOne(ExamQuestion::class, ['id' => "question_id"]);
    }

    public function getAttempt()
    {
        return $this->hasOne(ExamAttempt::class, ['id' => "attempt_id"]);
    }

    public function behaviors()
    {
        return [
            [
                'class' => FileUploadBehavior::class,
                'attribute' => 'result',
                'filePath' => '@frontendRoot/result/[[attribute_attempt_id]]_[[attribute_question_id]]_[[attribute_tq_id]].[[extension]]',
                'fileUrl' => '@frontendInfo/result/[[attribute_attempt_id]]_[[attribute_question_id]]_[[attribute_tq_id]].[[extension]]',
            ],
        ];
    }

}