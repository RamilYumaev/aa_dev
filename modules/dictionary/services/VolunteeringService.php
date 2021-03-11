<?php


namespace modules\dictionary\services;

use modules\dictionary\forms\VolunteeringForm;
use modules\dictionary\models\Volunteering;
use modules\dictionary\repositories\JobEntrantRepository;
use modules\dictionary\repositories\VolunteeringRepository;
use modules\usecase\ServicesClass;

class VolunteeringService extends ServicesClass
{
    private $jobEntrantRepository;

    public function __construct(JobEntrantRepository $jobEntrantRepository, VolunteeringRepository $repository, Volunteering $model)
    {
        $this->jobEntrantRepository = $jobEntrantRepository;
        $this->repository = $repository;
        $this->model = $model;
    }

    public function createOne(VolunteeringForm $form, $model) {
        if($model){
            $volunteer = $this->repository->get($model->id);
            $volunteer->data($form);
        } else {
            $volunteer = Volunteering::create($form);
        }
        $this->repository->save($volunteer);
    }
}