<?php


namespace dod\models;


use backend\widgets\olimpic\OlipicListInOLymipViewWidget;
use dod\forms\DodCreateForm;
use dod\forms\DodEditForm;

class  Dod extends \yii\db\ActiveRecord
{

    const BIG_HALL = "Актовый зал";

    public static function tableName()
    {
        return 'dod';
    }

    public static function create(DodCreateForm $form, $faculty_id)
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

    public function edit(DodEditForm $form, $faculty_id)
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

    public static function labels(): array
    {
        $dod = new static();
        return $dod->attributeLabels();
    }

    public function dodRelation($id)
    {
        return self::find()->where(['id' => $id]);
    }

    public function getAddressAndAudNumberString(): string
    {
        return $this->addressString . " ";
    }

    public function getAddressString(): string
    {
        return "Адрес:" . $this->address;
    }

    public function isBigHall(): bool
    {
        return trim($this->aud_number) == self::BIG_HALL;
    }

    public function getAudNumberString(): string
    {
        if ($this->isBigHall()) {
            return $this->aud_number;
        }
        return $this->aud_number? "Аудитория №" . $this->aud_number: "";
    }

}