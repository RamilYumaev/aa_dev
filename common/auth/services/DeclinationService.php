<?php

namespace common\auth\services;

use aneeshikmat\yii2\Yii2TimerCountDown\Yii2TimerCountDown;
use common\auth\forms\DeclinationFioForm;
use common\auth\forms\SettingEmailCreateForm;
use common\auth\forms\SettingEmailEditForm;
use common\auth\models\DeclinationFio;
use common\auth\models\SettingEmail;
use common\auth\repositories\DeclinationFioRepository;
use common\auth\repositories\SettingEmailRepository;
use common\auth\repositories\UserRepository;

class DeclinationService
{
    private $repository;
    private $userRepository;

    public function __construct(
        UserRepository $userRepository,
        DeclinationFioRepository $repository
    )
    {
        $this->userRepository= $userRepository;
        $this->repository = $repository;
    }

    public function edit($id, DeclinationFioForm $form): void
    {
        $model= $this->repository->get($id);
        $model->edit($form);
        $this->repository->save($model);
    }

}
