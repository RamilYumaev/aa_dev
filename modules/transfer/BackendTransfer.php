<?php

namespace modules\transfer;

use modules\dictionary\helpers\JobEntrantHelper;
use modules\dictionary\models\JobEntrant;
use modules\entrant\components\UserNoJobEntrant;
use Yii;
use yii\base\ExitException;
use yii\base\Module;
use yii\filters\AccessControl;

class BackendTransfer extends Module
{
    public $controllerNamespace = 'modules\transfer\controllers\backend';

    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if(!$this->getJobEntrant() || $this->getJobEntrant()->isStatusDraft() || !$this->getJobEntrant()->isAgreement()) {
            Yii::$app->session->setFlash("warning", 'Страница недоступна');
            Yii::$app->getResponse()->redirect(['site/index']);
            try {
                Yii::$app->end();
            } catch (ExitException $e) {
            }
        }
        return true;
    }

    private function getJobEntrant(): ? JobEntrant
    {
        return Yii::$app->user->identity->jobEntrant();
    }

}