<?php


namespace common\models\auth;


class Profiles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profiles';
    }

    public static function create($last_name, $first_name, $patronymic, $phone, $country_id, $region_id) {
        $profile = new static();
        $profile->last_name = $last_name;
        $profile->first_name = $first_name;
        $profile->patronymic = $patronymic;
        $profile->phone = $phone;
        $profile->country_id = $country_id;
        $profile->region_id = $region_id;
        $profile->user_id = \Yii::$app->user->identity->getId();
        return $profile;
    }

    public function edit($last_name, $first_name, $patronymic, $phone, $country_id, $region_id) {
        $this->last_name = $last_name;
        $this->first_name = $first_name;
        $this->patronymic = $patronymic;
        $this->phone = $phone;
        $this->country_id = $country_id;
        $this->region_id = $region_id;
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
        $profile =  new static();
        return $profile->attributeLabels();
    }
}