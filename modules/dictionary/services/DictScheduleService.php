<?php
namespace modules\dictionary\services;

use modules\dictionary\models\DictSchedule;
use modules\dictionary\models\ScheduleVolunteering;
use modules\dictionary\repositories\DictScheduleRepository;
use modules\usecase\ServicesClass;


class DictScheduleService extends ServicesClass
{

    public function __construct(DictScheduleRepository $repository, DictSchedule $model)
    {
        $this->repository = $repository;
        $this->model = $model;
    }

    public function addSchedule($id, $jobEntrantId) {
        /** @var DictSchedule $model */
        $model = $this->repository->get($id);
        if($model->isCountEnd()){
            throw new \DomainException('На этот день нет места');
        }
        if($model->isEntrant($jobEntrantId)){
            throw new \DomainException('На этот день Вы взяли график');
        }
        if(ScheduleVolunteering::isDateWork($model->date, $jobEntrantId)){
            throw new \DomainException('Вы не можете работать в нескольких центрах в этот день '.$model->date);
        }
        ScheduleVolunteering::create($model->id, $jobEntrantId)->save();
    }
}