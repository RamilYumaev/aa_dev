<?php

namespace modules\transfer\behaviors;

use modules\transfer\models\TransferMpgu;
use yii\base\Behavior;
use yii\base\ExitException;
use yii\web\Controller;
use Yii;


class TransferRedirectBehavior  extends Behavior
{
    public $ids = [];
    /**
     * @var Controller
     */
    public $owner;

    public function events()
    {
        return [
           Controller::EVENT_BEFORE_ACTION=> 'beforeAction',
        ];
    }

    public function beforeAction($event)
    {
        $model = $this->transfer();
        if((!$model || ($model && !in_array($model->current_status, $model::ACTIVE))) && in_array($this->owner->action->id, $this->ids)) {
            Yii::$app->session->setFlash("warning", 'Страница недоступна');
            Yii::$app->getResponse()->redirect(['transfer/default/fix']);
            try {
                Yii::$app->end();
            } catch (ExitException $e) {
            }
        }
    }



    private function transfer()
    {
        return TransferMpgu::findOne($this->userWhere());
    }


    private function userWhere() {
        return ['user_id' => Yii::$app->user->identity->getId()];
    }
}