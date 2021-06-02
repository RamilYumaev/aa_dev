<?php

namespace modules\transfer;

use modules\entrant\components\UserNoJobEntrant;
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
        return (new UserNoJobEntrant())->redirect();
    }

}