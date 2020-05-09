<?php

namespace modules\entrant;

use frontend\components\UserNoEmail;
use yii\base\Module;
use yii\filters\AccessControl;

class Entrant extends Module
{
    public $controllerNamespace = 'modules\entrant\controllers';


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
        return (new UserNoEmail())->redirect();
    }

}