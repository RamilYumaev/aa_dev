<?php
namespace modules\entrant\widgets\information;

use modules\entrant\helpers\AddressHelper;
use modules\entrant\models\AdditionalInformation;
use modules\entrant\models\Address;
use yii\base\Widget;

class AdditionalInformationWidget extends Widget
{
    public $userId;
    public $view = "index";
    public function run()
    {
        $model = AdditionalInformation::findOne(['user_id' => $this->userId]);
        return $this->render($this->view, [
            'additional_information'=> $model,
            'userId' => $this->userId,
            'addressMoscow' =>$this->address()
        ]);
    }

    protected function address()
    {
        if (Address::find()->where(['type'=>AddressHelper::TYPE_REGISTRATION, 'user_id'=>$this->userId])->exists()) {
            return Address::findOne(['type'=>AddressHelper::TYPE_REGISTRATION, 'user_id'=>$this->userId]);
        }
        return null;
    }

}
