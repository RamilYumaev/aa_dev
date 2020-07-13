<?php


namespace modules\exam\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%exam_question_group}}".
 *
 * @property integer $id
 * @property integer $exam_id
 * @property  string $name
 **/


class ExamQuestionGroup extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%exam_question_group}}';
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
        ];
    }

}