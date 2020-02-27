<?php

namespace olympic\forms\auth;

use borales\extensions\phoneInput\PhoneInputValidator;
use dictionary\helpers\DictCountryHelper;
use dictionary\helpers\DictRegionHelper;
use olympic\helpers\auth\ProfileHelper;
use olympic\models\auth\Profiles;
use yii\base\Model;
use Yii;
class ProfileCreateForm extends Model
{

    public $last_name, $first_name, $patronymic, $phone, $country_id, $region_id, $gender;

    /**
     * {@inheritdoc}
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['last_name', 'first_name', 'phone', 'country_id', 'gender'], 'required'],
            [['country_id', 'region_id', 'gender'], 'integer'],
            [['last_name', 'first_name', 'patronymic'], 'string', 'min' => 1, 'max' => 255],
            [['last_name', 'first_name', 'patronymic'], 'match', 'pattern' => '/^[а-яёА-ЯЁ\-\s]+$/u',
                'message' => 'Значение поля должно содержать только буквы кириллицы пробел или тире'],
            [['phone'], 'string', 'max' => 25],
            ['phone', 'unique', 'targetClass' => Profiles::class, 'message' => 'Такой номер телефона уже зарегистрирован в нашей базе данных'],
            ['region_id', 'required', 'when' => function ($model) {
                return $model->country_id == 46;
            }, 'whenClient' => 'function (attribute, value) { return $("#profilecreateform-country_id").val() == 46}'],
            [['phone'], PhoneInputValidator::class],
        ];
    }

    public function attributeLabels(): array
    {
        return Profiles::labels();
    }

    public function regionList(): array
    {
        return DictRegionHelper::regionList();
    }

    public function genderList(): array
    {
        return ProfileHelper::typeOfGender();
    }

    public function countryList(): array
    {
        return DictCountryHelper::countryList();
    }

}