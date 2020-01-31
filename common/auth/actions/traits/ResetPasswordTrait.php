<?php
namespace common\auth\actions\traits;

use common\auth\actions\RequestAction;
use common\auth\actions\ResetAction;

trait ResetPasswordTrait
{
    public function actions()
    {
        return [
            'request' => [
                'class' => RequestAction::class,
            ],
            'confirm' => [
                'class' => ResetAction::class,
            ],
        ];

    }
}