<?php


namespace common\auth\services;

use common\auth\forms\PasswordResetRequestForm;
use common\auth\forms\ResetPasswordForm;
use common\auth\forms\SettingEmailForm;
use common\auth\models\SettingEmail;
use common\auth\repositories\SettingEmailRepository;
use common\auth\repositories\UserRepository;
use common\transactions\TransactionManager;
use Yii;

class SettingEmailService
{
    private $repository;

    public function __construct(
        SettingEmailRepository $repository
    )
    {
        $this->repository = $repository;
    }

    public function create(SettingEmailForm $form): void
    {
        $userId = Yii::$app->user->identity->getId();
        if (($user = $this->repository->findBySettingEmail()) != null) {
            $user->edit($form);
        }else {
            $user = SettingEmail::create($userId, $form);
        }
        $this->repository->save($user);
    }


}
