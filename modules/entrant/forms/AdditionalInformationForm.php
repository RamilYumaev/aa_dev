<?php


namespace modules\entrant\forms;

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\helpers\AnketaHelper;
use modules\entrant\models\AdditionalInformation;
use modules\entrant\models\Anketa;
use modules\entrant\models\InsuranceCertificateUser;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class AdditionalInformationForm extends Model
{
    public $voz_id, $user_id, $resource_id, $hostel_id, $transfer_in_epgu, $chernobyl_status_id, $is_epgu, $is_time,
        $mpgu_training_status_id, $mark_spo, $insuranceNumber;

    private $_additionalInformation;
    private $_anketa;
    public $is_military_edu;

    public function __construct(Anketa $anketa, AdditionalInformation $additionalInformation = null, $config = [])
    {
        if ($additionalInformation) {
            $this->setAttributes($additionalInformation->getAttributes(), false);
            $this->_additionalInformation = $additionalInformation;
            $this->insuranceNumber = $additionalInformation->insuranceCertificate ? $additionalInformation->insuranceCertificate->number : '';
        }
        $this->user_id = $anketa->user_id;
        $this->_anketa = $anketa;
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            [DictCompetitiveGroupHelper::eduSpoExistsUser($this->user_id) ? ['resource_id'] : ['resource_id'], 'required'],
            [['voz_id', 'resource_id', 'hostel_id', 'transfer_in_epgu', 'is_military_edu', 'chernobyl_status_id', 'is_epgu', 'is_time', 'mpgu_training_status_id'], 'integer'],
            [['transfer_in_epgu', 'is_military_edu', 'chernobyl_status_id', 'is_epgu'], 'default', 'value' => 0],
            [['insuranceNumber'], 'string', 'max' => 14],
//            [['insuranceNumber'], 'required', 'when' => function($model) {
//               return $model->transfer_in_epgu;
//            }, 'enableClientValidation' => false],
            [['insuranceNumber'], 'validateInsuranceNumber'],
            $this->_additionalInformation && $this->_additionalInformation->insuranceCertificate ?
                [['insuranceNumber'], 'unique', 'targetClass' => InsuranceCertificateUser::class, 'targetAttribute' => 'number', 'filter' => ['<>', 'id', $this->_additionalInformation->insuranceCertificate->id]]
                : [['insuranceNumber'], 'unique', 'targetClass' => InsuranceCertificateUser::class, 'targetAttribute' => 'number',],
            [['mark_spo'], 'double', 'min' => 3.0, 'max' => 5.0, 'numberPattern' => '/^\d\.?\d{0,5}$/',
                'message' => 'Необходимо внести дробное число с точностью до 5 знаков после запятой'],
        ];
    }

    public function validateInsuranceNumber($attribute, $params)
    {
        if ($this->hasErrors() || !$this->insuranceNumber) {
            return;
        }

        if (!\preg_match('/\d{3}\-\d{3}\-\d{3} \d{2}/', $this->insuranceNumber)) {
            $this->addError($attribute, 'Формат СНИЛС не соотвествует стандарту.');
        }

        $snils = \preg_replace('/\-| /', '', $this->insuranceNumber);
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


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return (new AdditionalInformation())->attributeLabels() + ['insuranceNumber' => 'СНИЛС'];
    }

}