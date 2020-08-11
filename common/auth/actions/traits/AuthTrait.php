<?php

namespace common\auth\actions\traits;

use common\auth\actions\LoginAction;
use common\auth\actions\LoginTelegramAction;
use common\auth\actions\LogOutAction;
use common\components\AuthHandler;

trait AuthTrait
{
    public $role;
    public function actions()
    {
        return [
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
            'auth-telegram' => [
                'class' => LoginTelegramAction::class,
                'role' => $this->role,
            ],
            'login' => [
                'class' => LoginAction::class,
                'role' => $this->role
            ],
            'logout' => [
                'class' => LogOutAction::class,
            ],
        ];
    }

    public function onAuthSuccess($client)
    {
        (new AuthHandler($client, $this->role))->handle();
    }
}