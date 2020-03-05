<?php


namespace olympic\models\auth;

use common\moderation\behaviors\ModerationBehavior;
use common\moderation\interfaces\YiiActiveRecordAndModeration;
use dictionary\helpers\DictCountryHelper;
use dictionary\helpers\DictRegionHelper;
use olympic\forms\auth\ProfileCreateForm;
use olympic\forms\auth\ProfileEditForm;
use common\auth\models\User;
use olympic\models\auth\queries\ProfilesQuery;
use olympic\models\behaviors\DeclinationBehavior;

class Profiles extends YiiActiveRecordAndModeration
{
    /**
     * {@inheritdoc}
     */
//    public function behaviors()
//    {
//        return [
//            'moderation' => [
//                'class' => ModerationBehavior::class,
//                'attributes' => ['last_name', 'first_name', 'patronymic', 'phone', 'country_id', 'region_id'],
//            ],
//            'declination' => [
//                'class' =>  DeclinationBehavior::class,
//               // 'data' =>$this->last_name,
//            ],
//
//        ];
//    }


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
        $profile->gender = $form->gender;
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

    public function setRole($role)
    {
       $this->role = $role;
    }


    public function edit(ProfileEditForm $form)
    {
        $this->last_name = $form->last_name;
        $this->first_name = $form->first_name;
        $this->patronymic = $form->patronymic;
        $this->phone = $form->phone;
        $this->gender = $form->gender;
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
            'gender'=> "Пол"
        ];
    }

    public static function labels(): array
    {
        $profile = new static();
        return $profile->attributeLabels();
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getFio()
    {
        if (!empty($this->last_name) && !empty($this->last_name) && !empty($this->patronymic)) {
          return  $this->last_name ." ".$this->first_name." ".$this->patronymic;
        }
        elseif(!empty($this->last_name) && !empty($this->first_name)) {
            return  $this->last_name ." ".$this->first_name;
        }
        return null;
    }

    public static function find()
    {
        return new ProfilesQuery(static::class);
    }

    public function isNullProfile() {
        return $this->last_name == "" ||
        $this->first_name == "" ||
        $this->patronymic == "" ||
        $this->phone == "";
    }

    public function titleModeration(): string
    {
        return  "Профиль";
    }

    public function moderationAttributes($value): array
    {
      return  [
          'last_name' => $value,
          'first_name'=>$value, 'patronymic'=> $value,
          'phone' => $value,
          'country_id'=> DictCountryHelper::countryName($value) ,
          'region_id'=> DictRegionHelper::regionName($value)];
    }
}