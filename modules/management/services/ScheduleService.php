<?php


namespace modules\management\services;

use common\transactions\TransactionManager;
use modules\management\forms\ScheduleForm;
use modules\management\models\ManagementUser;
use modules\management\models\PostRateDepartment;
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
            if(!$model->isBlocked) {
                $this->deleteRelation($model->user_id);
                $this->saveManagementUser($form, $model->user_id);
            }
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
        $sumRate = PostRateDepartment::find()->where(['id' => $form->postList])->sum('rate');
        $maxRate = $sumRate;
        $sumRate = $sumRate >= PostRateDepartment::FULL_RATE ?  PostRateDepartment::FULL_RATE : $sumRate;
        $even = $schedule->getCountHours('even',  $sumRate);
        $odd = $schedule->getCountHours('odd',  $sumRate);

        if($maxRate > PostRateDepartment::FULL_RATE_HALF_RATE)
        {
            throw new \Exception('Сумма рабочих ставок может составляться не более 1,5 ставки');
        }
        if($sumRate != $odd)
        {
            throw new \Exception('Не совпадет с количеством рабочих часов нечетной недели.  У Вас '.$odd. ' ч. Должно быть '.$sumRate. ' часов');
        }
        if($sumRate != $even)
        {
            throw new \Exception('Не совпадет с количеством рабочих часов четной недели. У Вас '.$even. ' ч. Должно быть '. $sumRate. ' часов');
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

    /**
     * @param $id
     * @param $is
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */

    public function blocked($id, $is)
    {
        $model = $this->repository->get($id);
        $model->setIsBlocked($is);
        $this->repository->save($model);
    }
}