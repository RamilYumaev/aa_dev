<?php


namespace dod\models;


use dod\forms\DodForm;

class  Dod extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'dod';
    }

    public static function create(DodForm $form, $faculty_id)
    {
        $dod = new static();
        $dod->name = $form->name;
        $dod->type = $form->type;
        $dod->address = $form->address;
        $dod->aud_number = $form->aud_number;
        $dod->description = $form->description;
        $dod->faculty_id = $faculty_id;
        $dod->edu_level = $form->edu_level;
        $dod->photo_report = $form->photo_report;
        $dod->slug = $form->slug;
        return $dod;
    }

    public function edit (DodForm $form, $faculty_id)
    {
        $this->name = $form->name;
        $this->type = $form->type;
        $this->address = $form->address;
        $this->aud_number = $form->aud_number;
        $this->description = $form->description;
        $this->faculty_id = $faculty_id;
        $this->edu_level = $form->edu_level;
        $this->photo_report = $form->photo_report;
        $this->slug = $form->slug;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Название мероприятия',
            'description' => 'Описание',
            'type' => 'Общеуниверситетский день открытых дверей',
            'faculty_id' => 'Институт/факультет',
            'address' => 'Адрес',
            'photo_report' => 'Ссылка на фотоотчет',
            'edu_level' => 'Уровень образования',
            'aud_number' => 'Номер аудиории',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFaculty()
    {
        return $this->hasOne(DictFaculty::className(), ['id' => 'faculty_id']);
    }

    public function getDateDod()
    {
        return $this->hasMany(DateDod::className(), ['dod_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMasterClasses()
    {
        return $this->hasMany(MasterClass::className(), ['dod_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserDods()
    {
        return $this->hasMany(UserDod::className(), ['dod_id' => 'id']);
    }

    public static function isCommonDod($id, $eduLevel, $convert = true)
    {
        if ($convert) {
            $dodDate = DateDod::find()->andWhere(['id' => $id])->one();
            $dodId = $dodDate->dod_id ?? null;

            return Dod::find()
                ->andWhere(['id' => $dodId])
                ->andWhere(['type' => true])
                ->andWhere(['edu_level' => $eduLevel])
                ->exists();
        } else {
            return Dod::find()
                ->andWhere(['id' => $id])
                ->andWhere(['type' => true])
                ->andWhere(['edu_level' => $eduLevel])
                ->exists();

        }
    }
}