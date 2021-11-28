<?php

namespace modules\student\model;

use Yii;
use dictionary\models\Faculty as DictFaculty;
/**
 * This is the model class for table "teacher_faculty".
 *
 * @property int $dict_faculty_id
 * @property int $teacher_id
 *
 * @property DictFaculty $dictFaculty
 * @property Teacher $teacher
 */
class TeacherFaculty extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'teacher_faculty';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dict_faculty_id', 'teacher_id'], 'required'],
            [['dict_faculty_id', 'teacher_id'], 'integer'],
            [['dict_faculty_id', 'teacher_id'], 'unique', 'targetAttribute' => ['dict_faculty_id', 'teacher_id']],
            [['dict_faculty_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictFaculty::className(), 'targetAttribute' => ['dict_faculty_id' => 'id']],
            [['teacher_id'], 'exist', 'skipOnError' => true, 'targetClass' => Teacher::className(), 'targetAttribute' => ['teacher_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'dict_faculty_id' => 'Dict Faculty ID',
            'teacher_id' => 'Teacher ID',
        ];
    }

    /**
     * Gets query for [[DictFaculty]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDictFaculty()
    {
        return $this->hasOne(DictFaculty::className(), ['id' => 'dict_faculty_id']);
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
