<?php
namespace modules\transfer\widgets\transfer;

use modules\transfer\models\TransferMpgu;
use yii\base\Widget;

class TransferMpsuWidget extends Widget
{
    public $userId;
    public $view = "index-mpgu";

    public function run()
    {
        $model =TransferMpgu::findOne(['user_id'=> $this->userId]);
        return $this->render($this->view, [
            'model' => $model
        ]);
    }
}
