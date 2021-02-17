<?php

namespace modules\management;

use yii\base\Module;
use yii\filters\AccessControl;

class Management extends Module
{
    public $controllerNamespace = 'modules\management\controllers\user';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['entrant','dev']
                    ]
                ],
            ],
        ];
    }
}