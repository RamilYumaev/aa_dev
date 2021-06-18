<?php


namespace modules\transfer\models;

use common\moderation\behaviors\ModerationBehavior;
use common\moderation\interfaces\YiiActiveRecordAndModeration;
use dictionary\helpers\DictCountryHelper;
use modules\entrant\behaviors\FileBehavior;
use modules\entrant\forms\AddressForm;
use modules\entrant\helpers\AddressHelper;

/**
 * This is the model class for table "{{%insurance_certificate_user}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $number
**/
class InsuranceCertificateUser  extends \modules\entrant\models\InsuranceCertificateUser
{
    public function rules()
    {
        return [
            [['number'], 'required'],
            [['number'], 'string', 'max'=>14],
            [['number'], 'validateNumber'],
            [['number'], 'unique', 'targetClass' => 
                InsuranceCertificateUser::class, 'targetAttribute' => 'number']
        ];
    }

    public function validateNumber($attribute, $params)
    {
        if ($this->hasErrors() || !$this->number) {
            return;
        }

        if (!\preg_match('/\d{3}\-\d{3}\-\d{3} \d{2}/', $this->number)) {
            $this->addError($attribute, 'Формат СНИЛС не соотвествует стандарту.');
        }

        $snils = \preg_replace('/\-| /', '', $this->number);
        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += (int)$snils{$i} * (9 - $i);
        }
        $checkDigit = 0;
        if ($sum < 100) {
            $checkDigit = $sum;
        } elseif ($sum > 101) {
            $checkDigit = $sum % 101;
            if ($checkDigit === 100) {
                $checkDigit = 0;
            }
        }

        if ($checkDigit != (int)\substr($snils, -2)) {
            $this->addError($attribute, 'Проверьте правильность ввода СНИЛС.');
        }
    }
}