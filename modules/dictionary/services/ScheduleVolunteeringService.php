<?php


namespace modules\dictionary\services;

use modules\dictionary\forms\ReworkingVolunteeringForm;
use modules\dictionary\models\ReworkingVolunteering;
use modules\dictionary\repositories\ReworkingVolunteeringRepository;
use modules\dictionary\repositories\ScheduleVolunteeringRepository;


class ScheduleVolunteeringService
{
    private $repository;
    private $reworkingVolunteeringRepository;

    public function __construct(ScheduleVolunteeringRepository $repository,
                                ReworkingVolunteeringRepository $reworkingVolunteeringRepository)
    {
        $this->repository = $repository;
        $this->reworkingVolunteeringRepository = $reworkingVolunteeringRepository;
    }

    public function addAddRework($id, ReworkingVolunteeringForm $form) {
        /* @var $model \modules\dictionary\models\ScheduleVolunteering */
        $model = $this->repository->get($id);
        $reworkingModel = $model->reworkingVolunteering;
        if($reworkingModel) {
            $modelReworking = $this->reworkingVolunteeringRepository->get($reworkingModel->id);
            $modelReworking->data($form);
            $this->reworkingVolunteeringRepository->save($modelReworking);
        }else {
            $modelReworking = ReworkingVolunteering::create($form, $model->id);
            $this->reworkingVolunteeringRepository->save($modelReworking);
        }
     }
}