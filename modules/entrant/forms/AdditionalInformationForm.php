<?php


namespace modules\entrant\forms;
use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\models\AdditionalInformation;
use modules\entrant\models\InsuranceCertificateUser;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class AdditionalInformationForm extends Model
{
    public $voz_id, $user_id, $resource_id, $hostel_id, $chernobyl_status_id, $mpgu_training_status_id, $mark_spo, $insuranceNumber;

    private $_additionalInformation;

    public function __construct($user_id, AdditionalInformation $additionalInformation = null, $config = [])
    {
        if($additionalInformation){
            $this->setAttributes($additionalInformation->getAttributes(), false);
            $this->_additionalInformation= $additionalInformation;
            $this->insuranceNumber = $additionalInformation->insuranceCertificate ? $additionalInformation->insuranceCertificate->number : '';
        }
        $this->user_id = $user_id;
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            [DictCompetitiveGroupHelper::eduSpoExistsUser($this->user_id) ? ['resource_id','mark_spo'] : ['resource_id'], 'required'],
            [['voz_id', 'resource_id', 'hostel_id', 'chernobyl_status_id', 'mpgu_training_status_id'], 'integer'],
            [['insuranceNumber'], 'string', 'max'=>14],
            $this->_additionalInformation && $this->_additionalInformation->insuranceCertificate ?
                [['insuranceNumber'], 'unique', 'targetClass' => InsuranceCertificateUser::class, 'targetAttribute' => 'number', 'filter' => ['<>', 'id', $this->_additionalInformation->insuranceCertificate->id]]
                : [['insuranceNumber'], 'unique', 'targetClass' => InsuranceCertificateUser::class,'targetAttribute' => 'number',],
            [['mark_spo'], 'double', 'min' => 3.0, 'max' => 5.0, 'numberPattern' => '/^\d\.?\d{0,5}$/',
                'message'=> 'Необходимо внести дробное число с точностью до 5 знаков после запятой'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return (new AdditionalInformation())->attributeLabels()+['insuranceNumber'=> 'СНИЛС'];
    }

}