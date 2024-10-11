<?php

namespace olympic\models;
/**

 *
 * @property int $id
 * @property string $name
 * @property int $olympic_speciality_id
 *
 * @property-read OlympicSpeciality $olympicSpeciality
 *
 */
use yii\db\ActiveRecord;

class OlympicSpecialityProfile extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'olympic_speciality_profile';
    }

    public function rules()
    {
        return [
            [['name', 'olympic_speciality_id'], 'required'],
            [['name'], 'unique', 'targetAttribute' => ['name', 'olympic_speciality_id']],
            [['name'], 'string', 'max' => 255],
            [['olympic_speciality_id'], 'integer']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Наименование направления',
            'olympic_speciality_id' => 'Номинации олимпиады'
        ];
    }

    public function getFullName() {
        return $this->name. ' ('.$this->olympicSpeciality->name.')';
    }

    public function getOlympicSpeciality() {
        return $this->hasOne(OlympicSpeciality::class, ['id' => 'olympic_speciality_id']);
    }
}