<?php
namespace modules\entrant\widgets\other;

use modules\entrant\models\OtherDocument;
use yii\base\Widget;

class PreemptiveRightWidget extends Widget
{
    public $userId;

    public function run()
    {
        return $this->render('preemptive-right', ['user_id' => $this->userId]);
    }
}
