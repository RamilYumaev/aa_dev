<?php


namespace modules\dictionary\services;

use common\auth\rbac\Rbac;
use common\auth\repositories\UserRepository;
use common\transactions\TransactionManager;
use modules\dictionary\forms\JobEntrantAndProfileForm;
use modules\dictionary\forms\JobEntrantForm;
use modules\dictionary\models\JobEntrant;
use modules\dictionary\repositories\JobEntrantRepository;
use olympic\helpers\auth\ProfileHelper;
use olympic\models\auth\AuthAssignment;
use olympic\repositories\auth\ProfileRepository;
use yii\db\Exception;
use yii\db\StaleObjectException;

class JobEntrantService
{
    private $repository;
    private $transactionManager;
    private $profileRepository;
    private $userRepository;

    public function __construct(JobEntrantRepository $repository, ProfileRepository $profileRepository,
                                TransactionManager $transactionManager, UserRepository $userRepository)
    {
        $this->repository = $repository;
        $this->profileRepository = $profileRepository;
        $this->transactionManager = $transactionManager;
        $this->userRepository = $userRepository;
    }

    public function createEntrantJob (JobEntrantAndProfileForm $form, $model) {
        $this->transactionManager->wrap(function () use ($form, $model) {
            if($model){
                $jobEntrant = $this->repository->get($model->id);
                $jobEntrant->data($form->jobEntrant);
            } else {
                $jobEntrant = JobEntrant::create($form->jobEntrant);
            }
            $this->repository->save($jobEntrant);
            $profile  = $this->profileRepository->getUser($form->jobEntrant->user_id);
            $profile->edit($form->profile);
            $this->profileRepository->save($profile);
        });
    }

    public function create(JobEntrantForm $form)
    {
        $this->transactionManager->wrap(function () use ($form) {
            $model = JobEntrant::create($form);
            $this->repository->save($model);
            $this->roleProfile($model->user_id);
        });
    }

    public function edit($id, JobEntrantForm $form)
    {
        $this->transactionManager->wrap(function () use ($id, $form) {
        $model = $this->repository->get($id);
        $model->data($form);
        $this->roleProfile($model->user_id);
        $this->repository->save($model);
        });
    }

    public function status($id, $status)
    {
        $model = $this->repository->get($id);
        $model->setStatus($status);
        $this->repository->save($model);
    }
    public function remove($id)
    {
        $model = $this->repository->get($id);
        try {
            $this->repository->remove($model);
        } catch (StaleObjectException $e) {
        } catch (Exception $e) {
        }
    }

    private function roleProfile($userId) {
        $profile = $this->profileRepository->getUser($userId);
        $user = $this->userRepository->get($profile->user_id);
        if($profile->role != ProfileHelper::ROLE_ENTRANT) {
            $profile->setRole(ProfileHelper::ROLE_ENTRANT);
            $this->profileRepository->save($profile);
            if ($user){
                if(!AuthAssignment::findOne(['user_id'=>$user->id, 'item_name'=>Rbac::ROLE_ENTRANT])) {
                    $user->setAssignmentFirst(Rbac::ROLE_ENTRANT);
                }
            }
        }
    }
}