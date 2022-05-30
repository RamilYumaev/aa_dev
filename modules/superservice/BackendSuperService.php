<?php


namespace modules\superservice;


use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\base\Module;
use yii\filters\AccessControl;

class BackendSuperService extends Module
{
    public $controllerNamespace = 'modules\superservice\controllers\backend';

    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['dev']
                    ]
                ],
            ],
        ];
    }
}