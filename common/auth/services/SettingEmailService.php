<?php

namespace common\auth\services;

use aneeshikmat\yii2\Yii2TimerCountDown\Yii2TimerCountDown;
use common\auth\forms\SettingEmailCreateForm;
use common\auth\forms\SettingEmailEditForm;
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

    public function create(SettingEmailCreateForm $form): void
    {
        $user = $this->userRepository->get($form->user_id);
        $email = SettingEmail::create($user->id, $form);
        $this->repository->save($email);
    }

    public function edit($id, SettingEmailEditForm $form): void
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

    public function activate($id)
    {
        $model = $this->repository->get($id);
        try {
            $this->sendEmail($id)->send();
            $model->activate();
            $this->repository->save($model);
            \Yii::$app->session->setFlash('success', 'Проверено.');
        } catch (\Swift_TransportException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }

    private function sendEmail($id)
    {
        $mailer = \Yii::$app->olympicMailer;
        $mailer->idSettingEmail = $id;
        return $mailer
            ->mailer()
            ->compose()
            ->setFrom([$mailer->getFromSender() => \Yii::$app->name . ' robot'])
            ->setTo("markpdd13@list.ru")
            ->setSubject('Проверка ' . \Yii::$app->name);
    }
}
