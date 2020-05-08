<?php
namespace common\auth\actions\traits;
use common\auth\actions\AddEmailAction;
use common\auth\actions\ConfirmAction;
use common\auth\actions\SignUpAction;
use common\auth\actions\UserConfirmAction;
use common\auth\actions\UserEditAction;
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
            'user-edit' => [
                'class' => UserEditAction::class,
            ],
            'confirm-user' => [
                'class' => UserConfirmAction::class,
            ],
            'confirm' => [
                'class' => ConfirmAction::class,
            ],
        ];

    }
}