<?php

namespace modules\exam;

use yii\base\Module;
use yii\filters\AccessControl;

class AdminExam extends Module
{
    public $controllerNamespace = 'modules\exam\controllers\admin';

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
}
