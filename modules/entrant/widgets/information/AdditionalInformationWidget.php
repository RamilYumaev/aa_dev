<?php
namespace modules\entrant\widgets\information;

use modules\entrant\models\AdditionalInformation;
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
            'userId' => $this->userId
        ]);
    }

}
