<?php

namespace modules\student\model;

use Yii;

/**
 * This is the model class for table "teacher".
 *
 * @property int $id
 * @property string $name
 * @property int|null $isActive
 *
 * @property ScheduleLessonsDate[] $scheduleLessonsDates
 * @property ScheduleLessonsTeacher[] $scheduleLessonsTeachers
 * @property ScheduleLessons[] $scheduleLessons
 * @property TeacherFaculty[] $teacherFaculties
 * @property DictFaculty[] $dictFaculties
 */
class Teacher extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'teacher';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['isActive'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'isActive' => 'Is Active',
        ];
    }

    /**
     * Gets query for [[ScheduleLessonsDates]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getScheduleLessonsDates()
    {
        return $this->hasMany(ScheduleLessonsDate::className(), ['teacher_id' => 'id']);
    }

    /**
     * Gets query for [[ScheduleLessonsTeachers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getScheduleLessonsTeachers()
    {
        return $this->hasMany(ScheduleLessonsTeacher::className(), ['teacher_id' => 'id']);
    }

    /**
     * Gets query for [[ScheduleLessons]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getScheduleLessons()
    {
        return $this->hasMany(ScheduleLessons::className(), ['id' => 'schedule_lessons_id'])->viaTable('schedule_lessons_teacher', ['teacher_id' => 'id']);
    }

    /**
     * Gets query for [[TeacherFaculties]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTeacherFaculties()
    {
        return $this->hasMany(TeacherFaculty::className(), ['teacher_id' => 'id']);
    }

    /**
     * Gets query for [[DictFaculties]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDictFaculties()
    {
        return $this->hasMany(DictFaculty::className(), ['id' => 'dict_faculty_id'])->viaTable('teacher_faculty', ['teacher_id' => 'id']);
    }
}
