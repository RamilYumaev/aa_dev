<?php

namespace olympic\forms\auth;

use dictionary\helpers\DictCountryHelper;
use dictionary\helpers\DictRegionHelper;
use olympic\models\auth\Profiles;
use yii\base\Model;
use Yii;
class ProfileEditForm extends Model
{

    public $last_name, $first_name, $patronymic, $phone, $country_id, $region_id;

    private $_profile;

    /**
     * {@inheritdoc}
     */
    public function __construct($config = [])
    {
        $user = Yii::$app->user->identity->getId();
        $this->_profile = Profiles::findOne(['user_id' => $user]);
        $this->last_name = $this->_profile->last_name;
        $this->first_name = $this->_profile->first_name;
        $this->patronymic = $this->_profile->patronymic;
        $this->phone = $this->_profile->phone;
        $this->country_id = $this->_profile->country_id;
        $this->region_id = $this->_profile->region_id;
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['last_name', 'first_name', 'phone', 'country_id'], 'required'],
            [['country_id', 'region_id'], 'integer'],
            [['last_name', 'first_name', 'patronymic'], 'string', 'min' => 1, 'max' => 255],
            [['last_name', 'first_name', 'patronymic'], 'match', 'pattern' => '/^[а-яА-Я\-\s]+$/u',
                'message' => 'Значение поля должно содержать только буквы кириллицы пробел или тире'],
            [['phone'], 'string', 'max' => 25],
            ['phone', 'unique', 'targetClass' => Profiles::class, 'filter' => ['<>', 'id', $this->_profile->id], 'message' => 'Такой номер телефона уже зарегистрирован в нашей базе данных'],
            ['region_id', 'required', 'when' => function ($model) {
                return $model->country_id == 46;
            }, 'whenClient' => 'function (attribute, value) { return $("#profileeditform-country_id").val() == 46}'],
            ['phone', 'match', 'pattern' => '/^\+7\(\d{3}\)\d{3}\-\d{2}\-\d{2}$/', 'message' => 'неверный формат телефона!']
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

    public function countryList(): array
    {
        return DictCountryHelper::countryList();
    }

}