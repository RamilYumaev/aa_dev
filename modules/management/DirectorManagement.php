<?php

namespace modules\management;

use modules\management\models\ManagementUser;
use Yii;
use yii\base\Module;
use yii\filters\AccessControl;

class DirectorManagement extends Module
{
    public $controllerNamespace = 'modules\management\controllers\director';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['dev', 'work']
                    ]
                ],
            ],
        ];
    }

    /**
     * @param \yii\base\Action $action
     * @return bool
     * @throws \yii\base\ExitException
     */
    public function beforeAction($action)
    {
        if (!Yii::$app->user->getIsGuest() && $user = Yii::$app->user->identity->getId()) {
            $management = ManagementUser::find();
            $md = clone $management;
            $isAssistant = $management->user($user)->assistant()->exists();
            $isDirector = $md->userDirector($user)->exists();
            if(!$isDirector && !$isAssistant) {
                Yii::$app->session->setFlash('warning', "Доступ закрыт, так как Вы не являетесь помощником или постановшикаом задач");
                Yii::$app->getResponse()->redirect(['site/index']);
                Yii::$app->end();
            }
        }
        return true;
    }
}