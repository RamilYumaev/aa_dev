<?php

namespace modules\dictionary;

use yii\base\Module;
use yii\filters\AccessControl;

class Dictionary extends Module
{
    public $controllerNamespace = 'modules\dictionary\controllers';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['dev', 'edu_school']
                    ]
                ],
            ],
        ];
    }
}