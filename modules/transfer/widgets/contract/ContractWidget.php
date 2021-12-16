<?php

namespace modules\transfer\widgets\contract;

use \yii\base\Widget;

class ContractWidget extends Widget
{
    public $view = "index-backend";
    public $model;

    public function run()
    {
        return $this->render($this->view, ["model"=> $this->model]);
    }
}