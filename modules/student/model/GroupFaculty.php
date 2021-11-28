<?php

namespace modules\student\model;

use Yii;
use dictionary\models\Faculty as DictFaculty;
/**
 * This is the model class for table "group_faculty".
 *
 * @property int $id
 * @property int $dict_faculty_id
 * @property string $name
 * @property string $year_education
 *
 * @property DictFaculty $dictFaculty
 * @property ScheduleLessons[] $scheduleLessons
 */
class GroupFaculty extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'group_faculty';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dict_faculty_id', 'name', 'year_education'], 'required'],
            [['dict_faculty_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['year_education'], 'string', 'max' => 10],
            [['dict_faculty_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictFaculty::className(), 'targetAttribute' => ['dict_faculty_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dict_faculty_id' => 'Dict Faculty ID',
            'name' => 'Name',
            'year_education' => 'Year Education',
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
     * Gets query for [[ScheduleLessons]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getScheduleLessons()
    {
        return $this->hasMany(ScheduleLessons::className(), ['group_faculty_id' => 'id']);
    }
}
