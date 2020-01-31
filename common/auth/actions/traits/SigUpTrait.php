<?php
namespace common\auth\actions\traits;
use common\auth\actions\AddEmailAction;
use common\auth\actions\ConfirmAction;
use common\auth\actions\SignUpAction;
use yii\captcha\CaptchaAction;

trait SigUpTrait
{
    public $role;

    public function actions()
    {
        return [
            'captcha' => [
                'class' => CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'request' => [
                'class' => SignUpAction::class,
                'role' => $this->role
            ],
            'add-email' => [
                'class' => AddEmailAction::class,
            ],
            'confirm' => [
                'class' => ConfirmAction::class,
            ],
        ];

    }
}