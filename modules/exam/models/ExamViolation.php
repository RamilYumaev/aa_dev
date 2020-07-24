<?php


namespace modules\exam\models;

use modules\exam\forms\ExamViolationForm;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%exam_violation}}".
 *
 * @property integer $id
 * @property integer $exam_statement_id
 * @property string $message
 * @property string $datetime
 *
 **/

class ExamViolation extends ActiveRecord
{
    public static function tableName()
    {
        return "{{%exam_violation}}";
    }

    public static function create( ExamViolationForm $form)
    {
        $violation = new static();
        $violation->data($form);
        return $violation;
    }

    public function data(ExamViolationForm $form)
    {
        $this->exam_statement_id = $form->exam_statement_id;
        $this->message = $form->message;
        $this->datetime = date("Y-m-d H:i:s");
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'message' => 'Сообщение',
            'datetime' => 'Дата и время',
            'exam_statement_id' => 'Заявка на экзамен',
        ];
    }


    public static function labels()
    {
        $test = new static();
        return $test->attributeLabels();
    }


}