<?php

namespace modules\student\model;
use dictionary\models\Faculty as DictFaculty;
use Yii;

/**
 * This is the model class for table "discipline_education_faculty".
 *
 * @property int $dict_faculty_id
 * @property int $discipline_education_id
 *
 * @property DictFaculty $dictFaculty
 * @property DisciplineEducation $disciplineEducation
 */
class DisciplineEducationFaculty extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'discipline_education_faculty';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dict_faculty_id', 'discipline_education_id'], 'required'],
            [['dict_faculty_id', 'discipline_education_id'], 'integer'],
            [['dict_faculty_id', 'discipline_education_id'], 'unique', 'targetAttribute' => ['dict_faculty_id', 'discipline_education_id']],
            [['dict_faculty_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictFaculty::className(), 'targetAttribute' => ['dict_faculty_id' => 'id']],
            [['discipline_education_id'], 'exist', 'skipOnError' => true, 'targetClass' => DisciplineEducation::className(), 'targetAttribute' => ['discipline_education_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'dict_faculty_id' => 'Dict Faculty ID',
            'discipline_education_id' => 'Discipline Education ID',
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
     * Gets query for [[DisciplineEducation]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDisciplineEducation()
    {
        return $this->hasOne(DisciplineEducation::className(), ['id' => 'discipline_education_id']);
    }
}
