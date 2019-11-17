<?php


namespace olympic\models\auth;

use dictionary\helpers\DictCountryHelper;
use olympic\forms\auth\ProfileCreateForm;
use olympic\forms\auth\ProfileEditForm;

class Profiles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profiles';
    }

    public static function create(ProfileCreateForm $form, $user_id)
    {
        $profile = new static();
        $profile->last_name = $form->last_name;
        $profile->first_name = $form->first_name;
        $profile->patronymic = $form->patronymic;
        $profile->phone = $form->phone;
        $profile->country_id = $form->country_id;
        $profile->region_id = $form->country_id == DictCountryHelper::RUSSIA ? $form->region_id : null;
        $profile->user_id = $user_id;
        return $profile;
    }

    public static function createDefault($user_id)
    {
        $profile = new static();
        $profile->last_name = "";
        $profile->first_name = "";
        $profile->patronymic = "";
        $profile->phone = "";
        $profile->country_id = null;
        $profile->region_id = null;
        $profile->user_id = $user_id;
        return $profile;
    }

    public function edit(ProfileEditForm $form)
    {
        $this->last_name = $form->last_name;
        $this->first_name = $form->first_name;
        $this->patronymic = $form->patronymic;
        $this->phone = $form->phone;
        $this->country_id = $form->country_id;
        $this->region_id = $form->country_id == DictCountryHelper::RUSSIA ? $form->region_id : null;
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
            'country_id' => 'Страна проживания',
            'region_id' => 'Регион проживания',
        ];
    }

    public static function labels(): array
    {
        $profile = new static();
        return $profile->attributeLabels();
    }
}