<?php

namespace modules\entrant\widgets\contract;

use \yii\base\Widget;

class ReceiptContractWidget extends Widget
{
    public $view = "index-backend-receipt";
    public $model;

    public function run()
    {
        return $this->render($this->view, ["model"=> $this->model]);
    }
}