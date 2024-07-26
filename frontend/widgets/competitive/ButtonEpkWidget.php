<?php
namespace frontend\widgets\competitive;

use yii\base\Widget;

class ButtonEpkWidget extends Widget
{
    public $types;

    public function run()
    {
        return $this->render('button-epk', [
            'types' => $this->types
        ]);
    }
}