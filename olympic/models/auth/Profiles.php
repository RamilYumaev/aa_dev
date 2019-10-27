<?php


namespace olympic\models\auth;

use olympic\forms\auth\ProfileForm;

class Profiles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profiles';
    }

    public static function create(ProfileForm $form) {
        $profile = new static();
        $profile->last_name = $form->last_name;
        $profile->first_name = $form->first_name;
        $profile->patronymic = $form->patronymic;
        $profile->phone = $form->phone;
        $profile->country_id = $form->country_id;
        $profile->region_id = $form->region_id;
        $profile->user_id = \Yii::$app->user->identity->getId();
        return $profile;
    }

    public function edit(ProfileForm $form) {
        $this->last_name = $form->last_name;
        $this->first_name = $form->first_name;
        $this->patronymic = $form->patronymic;
        $this->phone = $form->phone;
        $this->country_id = $form->country_id;
        $this->region_id = $form->region_id;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'last_name' => 'Фамилия:',
            'first_name' => 'Имя:',
            'patronymic' => 'Отчество:',
            'phone' => 'Номер телефона:',
            'country_id' => 'Укажите страну проживания',
            'region_id' => 'Укажите субъект РФ',
        ];
    }

    public static function labels(): array
    {
        $profile = new static();
        return $profile->attributeLabels();
    }
}