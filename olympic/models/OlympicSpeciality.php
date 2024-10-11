<?php

namespace olympic\models;

/**
 *
 *
 * @property int $id
 * @property string $name
 * @property-read OlympicSpecialityProfile[] $olympicSpecialityProfiles
 */
use yii\db\ActiveRecord;

class OlympicSpeciality extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'olympic_speciality';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'unique'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Наименование',
        ];
    }

    public function getOlympicSpecialityProfiles() {
        return $this->hasMany(OlympicSpecialityProfile::class, ['olympic_speciality_id' =>'id']);
    }

    public static function all() {
        return static::find()->select('name, id')->indexBy('id')->column();
    }
}