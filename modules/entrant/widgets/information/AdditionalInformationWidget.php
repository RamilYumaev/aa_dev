<?php
namespace modules\entrant\widgets\information;

use modules\entrant\models\AdditionalInformation;
use yii\base\Widget;

class AdditionalInformationWidget extends Widget
{
    public function run()
    {
        $model = AdditionalInformation::findOne(['user_id' => $this->userId()]);
        return $this->render('index', [
            'additional_information'=> $model
        ]);
    }

    private function userId() {
        return \Yii::$app->user->identity->getId();
    }
}
