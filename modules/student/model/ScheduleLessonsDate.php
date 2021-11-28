<?php

namespace modules\student\model;

use Yii;

/**
 * This is the model class for table "schedule_lessons_date".
 *
 * @property int $id
 * @property int $schedule_lessons_id
 * @property int $teacher_id
 * @property string $date
 * @property string|null $text
 *
 * @property ScheduleLessons $scheduleLessons
 * @property Teacher $teacher
 */
class ScheduleLessonsDate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'schedule_lessons_date';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['schedule_lessons_id', 'teacher_id', 'date'], 'required'],
            [['schedule_lessons_id', 'teacher_id'], 'integer'],
            [['date'], 'safe'],
            [['text'], 'string'],
            [['schedule_lessons_id'], 'exist', 'skipOnError' => true, 'targetClass' => ScheduleLessons::className(), 'targetAttribute' => ['schedule_lessons_id' => 'id']],
            [['teacher_id'], 'exist', 'skipOnError' => true, 'targetClass' => Teacher::className(), 'targetAttribute' => ['teacher_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'schedule_lessons_id' => 'Schedule Lessons ID',
            'teacher_id' => 'Teacher ID',
            'date' => 'Date',
            'text' => 'Text',
        ];
    }

    /**
     * Gets query for [[ScheduleLessons]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getScheduleLessons()
    {
        return $this->hasOne(ScheduleLessons::className(), ['id' => 'schedule_lessons_id']);
    }

    /**
     * Gets query for [[Teacher]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTeacher()
    {
        return $this->hasOne(Teacher::className(), ['id' => 'teacher_id']);
    }
}
