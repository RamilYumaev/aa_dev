<?php
namespace modules\entrant\widgets\other;

use modules\entrant\models\OtherDocument;
use yii\base\Widget;

class PreemptiveRightWidget extends Widget
{

    public function run()
    {
        return $this->render('preemptive-right', ['user_id' => $this->getIdUser()]);
    }


    private function getIdUser() {
        return \Yii::$app->user->identity->getId();
    }


}
