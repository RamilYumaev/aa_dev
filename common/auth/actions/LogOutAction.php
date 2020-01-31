<?php
namespace common\auth\actions;
use Yii;

class LogOutAction extends \yii\base\Action
{

    public function run()
    {
        Yii::$app->user->logout();
        return $this->controller->goHome();
    }

}