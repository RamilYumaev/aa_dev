<?php


namespace modules\entrant\forms;
use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\models\AdditionalInformation;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class AdditionalInformationForm extends Model
{
    public $voz_id, $user_id, $resource_id, $hostel_id, $chernobyl_status_id, $mpgu_training_status_id, $mark_spo;

    private $_additionalInformation;

    public function __construct($user_id, AdditionalInformation $additionalInformation = null, $config = [])
    {
        if($additionalInformation){
            $this->setAttributes($additionalInformation->getAttributes(), false);
            $this->_additionalInformation= $additionalInformation;
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
            [['mark_spo'], 'number', 'min' => 0, 'max'=> 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return (new AdditionalInformation())->attributeLabels();
    }

}