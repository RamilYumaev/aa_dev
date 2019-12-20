<?php

namespace common\auth\services;

use common\auth\forms\SettingEmailForm;
use common\auth\models\SettingEmail;
use common\auth\repositories\SettingEmailRepository;
use common\auth\repositories\UserRepository;

class SettingEmailService
{
    private $repository;
    private $userRepository;

    public function __construct(
        UserRepository $userRepository,
        SettingEmailRepository $repository
    )
    {
        $this->userRepository= $userRepository;
        $this->repository = $repository;
    }

    public function create(SettingEmailForm $form): void
    {
        $user = $this->userRepository->get($form->user_id);
        $email = SettingEmail::create($user->id, $form);
        $this->repository->save($email);
    }

    public function edit($id,SettingEmailForm $form): void
    {
        $email= $this->repository->get($id);
        $user = $this->userRepository->get($form->user_id);
        $email->edit($user->id, $form);
        $this->repository->save($email);
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }






}
