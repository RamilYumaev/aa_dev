<?php

namespace modules\student\model;
use dictionary\models\Faculty as DictFaculty;
use Yii;

/**
 * This is the model class for table "audience_faculty".
 *
 * @property int $id
 * @property int $dict_faculty_id
 * @property string $name
 *
 * @property DictFaculty $dictFaculty
 * @property ScheduleLessons[] $scheduleLessons
 */
class AudienceFaculty extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'audience_faculty';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dict_faculty_id', 'name'], 'required'],
            [['dict_faculty_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
        return $this->hasMany(ScheduleLessons::className(), ['audience_faculty_id' => 'id']);
    }
}
