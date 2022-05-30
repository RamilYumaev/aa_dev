<?php
namespace modules\superservice\widgets;

use yii\base\Widget;

class FormWidgets extends Widget
{
    public function run()
    {
       return $this->render('index');
    }

}