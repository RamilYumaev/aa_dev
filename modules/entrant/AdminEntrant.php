<?php

namespace modules\entrant;

use modules\entrant\modules\ones\Ones;
use modules\entrant\modules\ones_2024\AdminOnes;
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
    public function init()
    {
        parent::init();
        $this->modules = [
            'ones' => ['class'=> Ones::class],
            'ss' => [
                'class'=> AdminOnes::class,
                'viewPath' => "@modules/entrant/modules/ones_2024/views/admin",]
        ];
    }
}
