<?php

namespace modules\student\forms;

use borales\extensions\phoneInput\PhoneInputValidator;
use common\auth\helpers\UserHelper;
use common\auth\models\User;
use olympic\models\auth\Profiles;
use yii\base\Model;

class MultiResetForm extends Model
{
    public $value;
    public $type;

    const SCENARIO_EMAIL = 'email';
    const SCENARIO_LOGIN = 'username';
    const SCENARIO_PHONE = 'phone';

    public function rules(): array
    {
        return [
            ['value', 'trim', 'on' => [self::SCENARIO_LOGIN, self::SCENARIO_PHONE, self::SCENARIO_EMAIL]],
            ['value', 'required', 'on' => [self::SCENARIO_LOGIN, self::SCENARIO_PHONE, self::SCENARIO_EMAIL]],
            ['value', 'email', 'on' => self::SCENARIO_EMAIL],
            ['value', 'exist',
                'on' => self::SCENARIO_EMAIL,
                'targetClass' => User::class,'targetAttribute' => ['value' => 'email'],
                'filter' => ['status' => UserHelper::STATUS_ACTIVE],
                'message' => 'Нет пользователя с таким адресом электронной почты или почта неподтверждена!'
            ],
            ['value', 'exist', 'on' => self::SCENARIO_LOGIN,
                'targetClass' => User::class,
                'targetAttribute' => ['value' => 'username'],
                'filter' => ['status' => UserHelper::STATUS_ACTIVE],
                'message' => 'Нет пользователя с таким логином или почта не неподтверждена!'
            ],
            ['value', 'string', 'max' => 25, 'on' => self::SCENARIO_PHONE],
            ['value', 'exist', 'targetClass' => Profiles::class,
                'targetAttribute' => ['value' => 'phone'],
                'message' => 'Нет пользователя с таким номером телефона!', 'on' => self::SCENARIO_PHONE],
            [['value'], PhoneInputValidator::class, 'on' => self::SCENARIO_PHONE],
            ['type', 'required'],
            ['type', 'string'],
            ['type', 'in', 'range' => [self::SCENARIO_LOGIN, self::SCENARIO_PHONE, self::SCENARIO_EMAIL]],
        ];
    }

    public function attributeLabels()
    {
        return ['type' => 'Тип сброса (email, username, phone)', 'value' => "Значение"];
    }
}