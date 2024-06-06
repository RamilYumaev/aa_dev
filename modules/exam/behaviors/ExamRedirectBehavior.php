<?php

namespace modules\exam\behaviors;

use modules\exam\helpers\ExamCgUserHelper;
use modules\exam\models\Exam;
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
           Controller::EVENT_BEFORE_ACTION => 'beforeAction',
        ];
    }

    public function beforeAction($event)
    {
        if(!$this->isRuleStatement()) {
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

    private function statementExam()  {
       return Exam::find()->joinWith('examStatement')->andWhere(['entrant_user_id' => Yii::$app->user->identity->getId()])->exists();
    }

    private function isRuleStatement() {
        if($this->examExits()) {
            return true;
        }
        if($this->statementExam()) {
            return  true;
        }
        return false;
    }
}