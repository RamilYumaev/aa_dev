<?php


namespace olympic\forms;


use common\auth\models\User;
use dictionary\helpers\DictCountryHelper;
use dictionary\helpers\DictRegionHelper;
use olympic\helpers\ClassAndOlympicHelper;
use olympic\models\auth\Profiles;
use olympic\models\Olympic;
use yii\base\Model;

class SignupOlympicForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $last_name, $first_name, $phone, $country_id, $patronymic, $school_id, $class_id;
    public $password_repeat;
    public $verifyCode;
    public $agree;
    private $_olympic;

    public function __construct(Olympic $olympic, $config = [])
    {
        $this->_olympic = $olympic;
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['last_name', 'first_name', 'phone', 'country_id', 'school_id', 'class_id'], 'required'],
            [['last_name', 'first_name', 'patronymic'], 'match', 'pattern' => '/^[а-яА-Я-\s]+$/u',
                'message' => 'В поле могут быть внесены только буквы кириллицы, пробелы или тире'],
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => User::class, 'message' => 'Этот логин уже существует.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'Этот адрес электронной почты уже существует.'],

            [['password', 'password_repeat'], 'required'],
            [['password', 'password_repeat'], 'string', 'min' => 6],
            [
                'password_repeat', 'compare', 'compareAttribute' => 'password',
                'message' => "Пароли не совпадают.", 'skipOnEmpty' => false,
                'when' => function ($model) {
                    return $model->password !== null && $model->password !== '';
                },
            ],

            ['phone', 'unique', 'targetClass' => Profiles::class, 'message' => 'Такой номер телефона уже зарегистрирован в нашей базе данных'],
            ['phone', 'match', 'pattern' => '/^\+7\(\d{3}\)\d{3}\-\d{2}\-\d{2}$/', 'message' => 'неверный формат телефона!'],

            ['regionId', 'required', 'when' => function ($model) {
                return $model->countryId == 46;
            }, 'whenClient' => 'function (attribute, value)
                {return $("#registrationolimpiads-countryid").val() == 46}'],

            ['verifyCode', 'captcha', 'captchaAction' => '/auth/signup/captcha'],
            ['agree', 'required', 'requiredValue' => true, 'message' => 'Согласитесь, пожалуйста, с обработкой персональных данных, поставив соответствующую "галочку"'],
            [['region_id', 'school_id', 'class_id', 'country_id'], 'integer'],
            ['patronymic', 'string'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'username' => 'Придумайте логин для личного кабинета (это может быть ваш email)',
            'email' => 'Адрес электронной почты:',
            'password' => 'Придумайте пароль',
            'password_repeat' => 'Повтор пароля',
            'last_name' => 'Фамилия',
            'first_name' => 'Имя',
            'patronymic' => 'Отчество',
            'phone' => 'Номер телефона',
            'country_id' => 'Страна проживания',
            'region_id' => 'Регион проживания',
            'school_id' => 'Выберите образовательную организацию, в которой Вы обучаетесь (обучались)',
            'class_id' => 'Выберите текущий класс/курс',
            'verifyCode' => 'Введите код с картинки',
            'agree' => 'Я согласен (согласна) на обработку моих персональных данных',
        ];
    }

    public function regionList(): array
    {
        return DictRegionHelper::regionList();
    }

    public function countryList(): array
    {
        return DictCountryHelper::countryList();
    }

    public function classFullNameList(): array
    {
        return ClassAndOlympicHelper::olympicClassRegisterList($this->_olympic->olympicOneLast->id);
    }

}