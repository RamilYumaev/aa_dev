<?php

namespace modules\student\forms;

use borales\extensions\phoneInput\PhoneInputValidator;
use common\auth\helpers\UserHelper;
use common\auth\models\User;
use olympic\models\auth\Profiles;
use yii\base\Model;

class MultiResetForm extends Model
{
    public $email;
    public $username;
    public $phone;
    public $type;

    const SCENARIO_EMAIL = 'email';
    const SCENARIO_LOGIN = 'username';
    const SCENARIO_PHONE = 'phone';

    public function rules(): array
    {
        return [
            ['email', 'trim', 'on' => self::SCENARIO_EMAIL],
            ['email', 'required', 'on' => self::SCENARIO_EMAIL],
            ['email', 'email', 'on' => self::SCENARIO_EMAIL],
            ['email', 'exist',
                'on' => self::SCENARIO_EMAIL,
                'targetClass' => User::class,
                'filter' => ['status' => UserHelper::STATUS_ACTIVE],
                'message' => 'Нет пользователя с таким адресом электронной почты или почта неподтверждена!'
            ],
            ['username', 'trim', 'on' => self::SCENARIO_LOGIN],
            ['username', 'required', 'on' => self::SCENARIO_LOGIN],
            ['username', 'exist', 'on' => self::SCENARIO_LOGIN,
                'targetClass' => User::class,
                'filter' => ['status' => UserHelper::STATUS_ACTIVE],
                'message' => 'Нет пользователя с таким логином или почта не неподтверждена!'
            ],
            ['phone', 'required', 'on' => self::SCENARIO_PHONE],
            [['phone'], 'string', 'max' => 25],
            ['phone', 'exist', 'targetClass' => Profiles::class,
                'message' => 'Нет пользователя с таким номером телефона!', 'on' => self::SCENARIO_PHONE],
            [['phone'], PhoneInputValidator::class, 'on' => self::SCENARIO_PHONE],
            ['type', 'required'],
            ['type', 'string'],
            ['type', 'in', 'range' => [self::SCENARIO_LOGIN, self::SCENARIO_PHONE, self::SCENARIO_EMAIL]],
        ];
    }

    public function attributeLabels()
    {
        return ['type' => 'Тип сброса', 'username' => 'login', ''];
    }
}