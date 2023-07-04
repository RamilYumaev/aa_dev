<?php
namespace modules\entrant\widgets\education;

use modules\entrant\models\AverageScopeSpo;
use yii\base\Widget;

class AverageScopeSpoWidget extends Widget
{
    public $userId;
    public $view = "spo-index";

    public function run()
    {
        $model = AverageScopeSpo::findOne(['user_id' => $this->userId]);
        return $this->render($this->view, [
            'model'=> $model,
        ]);
    }
}
