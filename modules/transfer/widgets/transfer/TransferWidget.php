<?php
namespace modules\transfer\widgets\transfer;

use modules\transfer\models\StatementTransfer;
use yii\base\Widget;

class TransferWidget extends Widget
{
    public $userId;
    public $view = "index";

    public function run()
    {
        $model = StatementTransfer::findOne(['user_id'=> $this->userId]);
        return $this->render($this->view, [
            'model' => $model
        ]);
    }
}
