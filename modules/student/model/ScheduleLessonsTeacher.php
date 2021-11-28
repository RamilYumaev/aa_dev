<?php

namespace modules\student\model;

use Yii;

/**
 * This is the model class for table "schedule_lessons_teacher".
 *
 * @property int $schedule_lessons_id
 * @property int $teacher_id
 *
 * @property ScheduleLessons $scheduleLessons
 * @property Teacher $teacher
 */
class ScheduleLessonsTeacher extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'schedule_lessons_teacher';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['schedule_lessons_id', 'teacher_id'], 'required'],
            [['schedule_lessons_id', 'teacher_id'], 'integer'],
            [['schedule_lessons_id', 'teacher_id'], 'unique', 'targetAttribute' => ['schedule_lessons_id', 'teacher_id']],
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
            'schedule_lessons_id' => 'Schedule Lessons ID',
            'teacher_id' => 'Teacher ID',
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
