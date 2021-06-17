<?php


namespace olympic\models\auth;

use borales\extensions\phoneInput\PhoneInputBehavior;
use common\moderation\behaviors\ModerationBehavior;
use common\moderation\interfaces\YiiActiveRecordAndModeration;
use dictionary\helpers\DictCountryHelper;
use dictionary\helpers\DictRegionHelper;
use modules\dictionary\models\JobEntrant;
use modules\dictionary\models\SettingEntrant;
use modules\entrant\helpers\BlockRedGreenHelper;
use modules\entrant\interfaces\models\DataModel;
use modules\entrant\models\Anketa;
use modules\entrant\models\File;
use modules\entrant\models\Statement;
use modules\entrant\models\UserAis;
use olympic\forms\auth\ProfileCreateForm;
use olympic\forms\auth\ProfileEditForm;
use common\auth\models\User;
use olympic\helpers\auth\ProfileHelper;
use olympic\models\auth\queries\ProfilesQuery;
use olympic\models\behaviors\DeclinationBehavior;

class Profiles extends YiiActiveRecordAndModeration implements DataModel
{
    /**
     * {@inheritdoc}
     */

    public function behaviors()
    {
        return [
            'moderation' => [
                'class' => ModerationBehavior::class,
                'attributes' => ['last_name', 'first_name', 'patronymic', 'gender', 'country_id', 'region_id', 'phone'],
                'attributesNoEncode' => ['phone']
            ],
            'declination' => [
                'class' => DeclinationBehavior::class,
            ],
            ['class' => PhoneInputBehavior::class],

        ];
    }

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
            'gender' => "Пол"
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

    public function firstNameAndPatronymic()
    {
        $patronymic = $this->patronymic ? " " . $this->patronymic : "";
        return $this->first_name . $patronymic;
    }

    public function getAnketa()
    {
        return $this->hasOne(Anketa::class, ['user_id' => 'user_id']);
    }

    public function getAis()
    {
        return $this->hasOne(UserAis::class, ['user_id' => 'user_id']);
    }

    public function getFile()
    {
        return $this->hasMany(File::class, ['user_id' => 'user_id']);
    }

    public function getStatement()
    {
        return $this->hasMany(Statement::class, ['user_id' => 'user_id']);
    }

    public function getJobEntrant()
    {
        return $this->hasOne(JobEntrant::class, ['user_id' => 'user_id']);
    }

    public function getFio()
    {
        if (!empty($this->last_name) && !empty($this->first_name) && !empty($this->patronymic) && !$this->twoWordIntoPatronymic()) {
            return $this->last_name . " " . $this->first_name . " " . $this->patronymic;
        } elseif (!empty($this->last_name) && !empty($this->first_name)) {
            return $this->last_name . " " . $this->first_name;
        }
        return null;
    }

    public function twoWordIntoPatronymic(): bool
    {
        $patronymic = $this->patronymic ?? "";
        $count = 0;
        if ($patronymic) {
            $count = count(explode(" ", $patronymic));
        }
        return $count > 1;
    }

    public static function find()
    {
        return new ProfilesQuery(static::class);
    }

    public function isNullProfile()
    {
        return $this->last_name == "" ||
            $this->first_name == "" ||
            $this->phone == "";
    }

    public function isDataNoEmpty(): bool
    {
        $arrayNoRequired = ['user_id', 'patronymic', 'id', 'role'];
        if ($this->isNoRussia()) {
            array_push($arrayNoRequired, 'region_id');
        }
        return BlockRedGreenHelper::dataNoEmpty($this->getAttributes(null, $arrayNoRequired));
    }

    public function isNoRussia()
    {
        return $this->country_id !== DictCountryHelper::RUSSIA;
    }

    public function titleModeration(): string
    {
        return "Профиль";
    }

    public function getCountryName()
    {
        return DictCountryHelper::countryName($this->country_id);
    }

    public function getGenderName()
    {
        return ProfileHelper::genderName($this->gender);
    }

    public function getRegionName()
    {
        return DictRegionHelper::regionName($this->region_id);
    }

    public function withBestRegard()
    {
        if ($this->gender == ProfileHelper::FEMALE) {
            return "Уважаемая";
        }
        if ($this->gender == ProfileHelper::MALE) {
            return "Уважаемый";
        }

        return "Уважаемый(-ая)";

    }

    public function moderationAttributes($value): array
    {
        return [
            'last_name' => $value,
            'first_name' => $value,
            'patronymic' => $value,
            'phone' => $value,
            'gender' => ProfileHelper::genderName($value),
            'country_id' => DictCountryHelper::countryName($value),
            'region_id' => DictRegionHelper::regionName($value)
        ];
    }

    public function data(): array
    {
        return [
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'patronymic' => $this->patronymic,
            'phone' => $this->phone,
            'gender' => $this->genderName,
            'country_id' => $this->CountryName,
            'region_id' => $this->regionName,
            'email' => $this->user->email,
        ];
    }

    public function getAisUser()
    {
        return $this->hasOne(UserAis::class, ['user_id' => 'user_id']);
    }
}