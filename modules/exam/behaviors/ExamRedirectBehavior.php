<?php

namespace modules\exam\behaviors;

use modules\exam\helpers\ExamCgUserHelper;
use yii\base\Behavior;
use yii\base\ExitException;
use yii\web\Controller;
use Yii;


class ExamRedirectBehavior  extends Behavior
{
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
        if(!$this->examExits()) {
            Yii::$app->session->setFlash("warning", 'Нет доступа к перечню экзаменов');
            Yii::$app->getResponse()->redirect(['/']);
            try {
                Yii::$app->end();
            } catch (ExitException $e) {
            }
        }
    }


    private function examExits()
    {
        return ExamCgUserHelper::examExists( Yii::$app->user->identity->getId());
    }



}