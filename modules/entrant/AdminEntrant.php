<?php

namespace modules\entrant;

use modules\entrant\components\UserNoJobEntrant;
use yii\base\Module;
use yii\filters\AccessControl;

class AdminEntrant extends Module
{
    public $controllerNamespace = 'modules\entrant\controllers\admin';

    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['dev-entrant']
                    ]
                ],
            ],
        ];
    }
}
