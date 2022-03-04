<?php
namespace modules\literature\forms;

use borales\extensions\phoneInput\PhoneInputValidator;
use olympic\models\auth\Profiles;
use yii\base\Model;

class PhoneEmailForm extends Model
{
    public $phone, $email;
    const PHONE = "phone";
    const EMAIL = "email";

    public function rules(): array
    {
        return [
            [['email'], 'required', 'on' => self::EMAIL],
            ['email', 'email', 'on' => self::EMAIL],
            [['email'], 'string', 'max' => 255, 'on' => self::EMAIL],
            [['email'], 'unique', 'on' => self::EMAIL, 'targetClass' => \common\auth\models\User::class],
            [['phone'], 'required', 'on' => self::PHONE],
            ['phone', 'unique', 'on' => self::PHONE, 'targetClass' => Profiles::class, 'message' => 'Такой номер телефона уже зарегистрирован в нашей базе данных'],
            [['phone'], PhoneInputValidator::class, 'on' => self::PHONE],
        ];
    }

    public function attributeLabels()
    {
        return ['phone' => "Телефон"];
    }
}
