<?php

namespace modules\exam;

use modules\entrant\components\UserNoJobEntrant;
use yii\base\Module;
use yii\filters\AccessControl;

class BackendExam extends Module
{
    public $controllerNamespace = 'modules\exam\controllers\backend';

    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['entrant']
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