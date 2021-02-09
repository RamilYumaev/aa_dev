<?php


namespace modules\management\services;

use common\transactions\TransactionManager;
use modules\management\forms\ScheduleForm;
use modules\management\models\ManagementUser;
use modules\management\models\Schedule;
use modules\management\repositories\ManagementUserRepository;
use modules\management\repositories\ScheduleRepository;
use yii\base\Model;

class ScheduleService
{
    private $repository;
    private $managementUserRepository, $transactionManager;

    public function __construct(ScheduleRepository $repository,    ManagementUserRepository $managementUserRepository,
                                TransactionManager $transactionManager)
    {
        $this->repository = $repository;
        $this->transactionManager =$transactionManager;
        $this->managementUserRepository = $managementUserRepository;
    }

    /**
     * @param ScheduleForm $form
     * @return Schedule
     * @throws \Exception
     */

    public function create(ScheduleForm $form): Schedule
    {
        $model = new Schedule();
        $model->setDataForm($form);
        $this->correctRate($form, $model);
        $this->transactionManager->wrap(function () use ($form, $model) {
            $this->saveManagementUser($form, $model->user_id);
            $this->repository->save($model);
        });

        return $model;
    }

    /**
     * @param $id
     * @param ScheduleForm $form
     * @throws \Exception
     */

    public function edit($id, ScheduleForm $form): void
    {
        $model = $this->repository->get($id);
        $model->setDataForm($form);
        $this->correctRate($form, $model);
        $this->transactionManager->wrap(function () use ($model, $form) {
            $this->deleteRelation($model->user_id);
            $this->saveManagementUser($form, $model->user_id);
            $model->save($model);
        });

    }

    /**
     * @param ScheduleForm $form
     * @throws \Exception
     */
    public function save(ScheduleForm $form) {
        $model = $this->repository->getUserId($form->user_id);
        if($model) {
            $this->edit($model->id, $form);
        }else {
            $this->create($form);
        }
    }

    /**
     * @param ScheduleForm $form
     * @param Schedule $schedule
     * @throws \Exception
     */
    private function correctRate (ScheduleForm $form, Schedule $schedule) {
        $even = $schedule->getCountHours('even');
        $odd = $schedule->getCountHours('odd');
        if($form->rate != $odd)
        {
            throw new \Exception('Не совпадет с количеством рабочих часов нечетной недели.  У Вас '.$odd. ' ч. Должно быть '.$form->rate. ' часов');
        }
        if($form->rate != $even)
        {
            throw new \Exception('Не совпадет с количеством рабочих часов четной недели. У Вас '.$even. ' ч. Должно быть '.$form->rate. ' часов');
        }
    }

    private function saveManagementUser(ScheduleForm $form, $user) {
        if ($form->postList) {
            foreach ($form->postList as $post) {
                $managementUser = ManagementUser::create($post, $user);
                $this->managementUserRepository->save($managementUser);
            }
        }
    }

    /**
     * @param $id
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->deleteRelation($model->user_id);
        $this->repository->remove($model);
    }

    private function deleteRelation($userId)
    {
        ManagementUser::deleteAll(['user_id' => $userId]);
    }

}