<?php


namespace common\forms\auth;

use common\models\auth\Profiles;
use yii\base\Model;

class ProfileForm extends Model
{

    public $last_name, $first_name, $patronymic, $phone, $country_id, $region_id;

    /**
     * {@inheritdoc}
     */
    public function __construct($config = [])
    {
        $profile = Profiles::findOne(['user_id'=> \Yii::$app->user->identity->getId()]);
        if($profile) {
            $this->last_name = $profile->last_name;
            $this->first_name = $profile->first_name;
            $this->patronymic = $profile->patronymic;
            $this->phone = $profile->phone;
            $this->country_id = $profile->country_id;
            $this->region_id = $profile->region_id;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['last_name', 'first_name', 'phone'], 'required'],
            [['country_id', 'region_id'], 'integer'],
            [['last_name', 'first_name', 'patronymic'], 'string', 'min' => 1, 'max' => 255],
            [['last_name', 'first_name', 'patronymic'], 'match', 'pattern' => '/^[а-яА-Я\-\s]+$/u',
                'message' => 'Значение поля должно содержать только буквы кириллицы пробел или тире'],
            [['phone'], 'string', 'max' => 25],
            ['phone', 'unique', 'targetClass' => Profiles::class,  'message' => 'Такой номер телефона уже зарегистрирован в нашей базе данных'],
            ['region_id', 'required', 'when' => function ($model) {
                return $model->country_id == 46;
            },
                'whenClient' => 'function (attribute, value)
                { return $("#profiles-country_id").val() == 46}'],
            ['phone', 'match', 'pattern' => '/^\+7\(\d{3}\)\d{3}\-\d{2}\-\d{2}$/', 'message' => 'неверный формат телефона!']
        ];
    }

    public function attributeLabels(): array
    {
        return  Profiles::labels();
    }

}