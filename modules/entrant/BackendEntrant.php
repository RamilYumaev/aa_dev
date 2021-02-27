<?php

namespace modules\entrant;

use modules\entrant\components\UserNoJobEntrant;
use yii\base\Module;
use yii\filters\AccessControl;

class BackendEntrant extends Module
{
    public $controllerNamespace = 'modules\entrant\controllers\backend';

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