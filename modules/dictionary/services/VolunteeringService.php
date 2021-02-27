<?php


namespace modules\dictionary\services;

use common\auth\rbac\Rbac;
use common\auth\repositories\UserRepository;
use common\transactions\TransactionManager;
use modules\dictionary\forms\JobEntrantAndProfileForm;
use modules\dictionary\forms\JobEntrantForm;
use modules\dictionary\forms\VolunteeringForm;
use modules\dictionary\models\JobEntrant;
use modules\dictionary\models\Volunteering;
use modules\dictionary\repositories\JobEntrantRepository;
use modules\dictionary\repositories\VolunteeringRepository;
use olympic\helpers\auth\ProfileHelper;
use olympic\models\auth\AuthAssignment;
use olympic\repositories\auth\ProfileRepository;
use yii\db\Exception;
use yii\db\StaleObjectException;

class VolunteeringService
{
    private $repository;
    private $jobEntrantRepository;

    public function __construct(JobEntrantRepository $jobEntrantRepository, VolunteeringRepository $repository)
    {
        $this->jobEntrantRepository = $jobEntrantRepository;
        $this->repository = $repository;
    }

    public function create(VolunteeringForm $form, $model) {
        if($model){
            $volunteer = $this->repository->get($model->id);
            $volunteer->data($form);
        } else {
            $volunteer = Volunteering::create($form);
        }
        $this->repository->save($volunteer);
    }
}