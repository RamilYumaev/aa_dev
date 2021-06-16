<?php

namespace modules\transfer;

use frontend\components\UserNoEmail;
use yii\base\Module;
use yii\filters\AccessControl;

class FrontendTransfer extends Module
{
    public  $controllerNamespace = 'modules\transfer\controllers\frontend';

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