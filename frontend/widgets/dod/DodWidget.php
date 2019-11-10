<?php
namespace frontend\widgets\dod;

use dod\models\DateDod;
use yii\base\Widget;

class DodWidget extends Widget
{
    public $type;
    /**
     * @var string
     */
    public $view;
    /**
     * @return string
     */
    public function run()
    {
        $model = DateDod::find()->dodTypeAll($this->type);
        return $this->render($this->view, [
            'model' => $model
        ]);
    }
}