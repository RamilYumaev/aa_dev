<?php

namespace modules\student\model;

use Yii;

/**
 * This is the model class for table "schedule_lessons".
 *
 * @property int $id
 * @property string $year_education
 * @property int $day_week
 * @property int $semester
 * @property int $group_faculty_id
 * @property int $number_pair
 * @property int $discipline_education_id
 * @property int $form
 * @property int $type_class
 * @property int|null $audience_faculty_id
 * @property int $type_group
 *
 * @property AudienceFaculty $audienceFaculty
 * @property DisciplineEducation $disciplineEducation
 * @property GroupFaculty $groupFaculty
 * @property ScheduleLessonsDate[] $scheduleLessonsDates
 * @property ScheduleLessonsTeacher[] $scheduleLessonsTeachers
 * @property Teacher[] $teachers
 */
class ScheduleLessons extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'schedule_lessons';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['year_education', 'day_week', 'semester', 'group_faculty_id', 'number_pair', 'discipline_education_id', 'form', 'type_class', 'type_group'], 'required'],
            [['day_week', 'semester', 'group_faculty_id', 'number_pair', 'discipline_education_id', 'form', 'type_class', 'audience_faculty_id', 'type_group'], 'integer'],
            [['year_education'], 'string', 'max' => 10],
            [['audience_faculty_id'], 'exist', 'skipOnError' => true, 'targetClass' => AudienceFaculty::className(), 'targetAttribute' => ['audience_faculty_id' => 'id']],
            [['discipline_education_id'], 'exist', 'skipOnError' => true, 'targetClass' => DisciplineEducation::className(), 'targetAttribute' => ['discipline_education_id' => 'id']],
            [['group_faculty_id'], 'exist', 'skipOnError' => true, 'targetClass' => GroupFaculty::className(), 'targetAttribute' => ['group_faculty_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'year_education' => 'Year Education',
            'day_week' => 'Day Week',
            'semester' => 'Semester',
            'group_faculty_id' => 'Group Faculty ID',
            'number_pair' => 'Number Pair',
            'discipline_education_id' => 'Discipline Education ID',
            'form' => 'Form',
            'type_class' => 'Type Class',
            'audience_faculty_id' => 'Audience Faculty ID',
            'type_group' => 'Type Group',
        ];
    }

    /**
     * Gets query for [[AudienceFaculty]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAudienceFaculty()
    {
        return $this->hasOne(AudienceFaculty::className(), ['id' => 'audience_faculty_id']);
    }

    /**
     * Gets query for [[DisciplineEducation]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDisciplineEducation()
    {
        return $this->hasOne(DisciplineEducation::className(), ['id' => 'discipline_education_id']);
    }

    /**
     * Gets query for [[GroupFaculty]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGroupFaculty()
    {
        return $this->hasOne(GroupFaculty::className(), ['id' => 'group_faculty_id']);
    }

    /**
     * Gets query for [[ScheduleLessonsDates]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getScheduleLessonsDates()
    {
        return $this->hasMany(ScheduleLessonsDate::className(), ['schedule_lessons_id' => 'id']);
    }

    /**
     * Gets query for [[ScheduleLessonsTeachers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getScheduleLessonsTeachers()
    {
        return $this->hasMany(ScheduleLessonsTeacher::className(), ['schedule_lessons_id' => 'id']);
    }

    /**
     * Gets query for [[Teachers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTeachers()
    {
        return $this->hasMany(Teacher::className(), ['id' => 'teacher_id'])->viaTable('schedule_lessons_teacher', ['schedule_lessons_id' => 'id']);
    }
}
