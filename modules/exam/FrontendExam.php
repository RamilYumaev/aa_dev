<?php

namespace modules\exam;

use frontend\components\UserNoEmail;
use yii\base\Module;
use yii\filters\AccessControl;

class FrontendExam extends Module
{
    public  $controllerNamespace = 'modules\exam\controllers\frontend';


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