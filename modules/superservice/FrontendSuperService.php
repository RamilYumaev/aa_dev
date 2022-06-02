<?php

namespace modules\superservice;

use yii\base\Module;
use yii\filters\AccessControl;

class FrontendSuperService extends Module
{
    public $controllerNamespace = 'modules\superservice\controllers\frontend';

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
}