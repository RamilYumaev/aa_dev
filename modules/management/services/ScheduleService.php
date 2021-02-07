<?php


namespace modules\management\services;

use modules\management\forms\ScheduleForm;
use modules\management\models\Schedule;
use modules\management\repositories\ScheduleRepository;

class ScheduleService
{
    private $repository;

    public function __construct(ScheduleRepository $repository)
    {
        $this->repository = $repository;
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
        $this->repository->save($model);
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
        $model->save($model);
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

    /**
     * @param $id
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }

}