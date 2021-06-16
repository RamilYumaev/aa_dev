<?php

namespace modules\transfer\behaviors;

use modules\transfer\models\File;
use yii\base\Behavior;
use yii\base\ExitException;
use yii\web\Controller;
use Yii;


class RedirectBehavior  extends Behavior
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
        if($this->fileExits() && in_array($this->owner->action->id, $this->ids)) {
            Yii::$app->session->setFlash("warning", 'Редактирование, удаление  
            невозможно, так как на странице "Загрузка документов" есть загруженная скан-копия документа');
            Yii::$app->getResponse()->redirect(['abiturient/post-document/index']);
            try {
                Yii::$app->end();
            } catch (ExitException $e) {
            }
        }
    }


    private function fileExits()
    {
        return File::find()->where($this->userWhere())->exists();
    }


    private function userWhere() {
        return ['user_id' => Yii::$app->user->identity->getId()];
    }
}