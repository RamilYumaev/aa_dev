<?php

namespace modules\student\model;

use Yii;
use dictionary\models\Faculty as DictFaculty;
/**
 * This is the model class for table "discipline_education".
 *
 * @property int $id
 * @property string $name
 *
 * @property DisciplineEducationFaculty[] $disciplineEducationFaculties
 * @property DictFaculty[] $dictFaculties
 * @property ScheduleLessons[] $scheduleLessons
 */
class DisciplineEducation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'discipline_education';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
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
        ];
    }

    /**
     * Gets query for [[DisciplineEducationFaculties]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDisciplineEducationFaculties()
    {
        return $this->hasMany(DisciplineEducationFaculty::className(), ['discipline_education_id' => 'id']);
    }

    /**
     * Gets query for [[DictFaculties]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDictFaculties()
    {
        return $this->hasMany(DictFaculty::className(), ['id' => 'dict_faculty_id'])->viaTable('discipline_education_faculty', ['discipline_education_id' => 'id']);
    }

    /**
     * Gets query for [[ScheduleLessons]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getScheduleLessons()
    {
        return $this->hasMany(ScheduleLessons::className(), ['discipline_education_id' => 'id']);
    }
}
