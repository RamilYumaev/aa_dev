<?php


namespace olympic\services;

use common\auth\rbac\Rbac;
use common\auth\rbac\RoleManager;
use common\auth\repositories\UserRepository;
use common\transactions\TransactionManager;
use olympic\forms\OlympicCreateForm;
use olympic\forms\OlympicEditForm;
use olympic\models\auth\AuthAssignment;
use olympic\models\Olympic;
use olympic\repositories\OlympicRepository;
use yii\rbac\Role;

class OlympicService
{
    private $repository;
    private $transactionManager;
    private $userRepository;
    private $roleManager;

    public function __construct(OlympicRepository $repository, TransactionManager $transactionManager, UserRepository $userRepository,
                                RoleManager $roleManager)
    {
        $this->repository = $repository;
        $this->roleManager = $roleManager;
        $this->transactionManager = $transactionManager;
        $this->userRepository = $userRepository;
    }

    public function create(OlympicCreateForm $form)
    {
        $user = $this->userRepository->get($form->managerId);
        $model = Olympic::create($form, $user->id);
        $this->transactionManager->wrap(function () use($user, $model) {
            $this->repository->save($model);
            if(!AuthAssignment::findOne(['user_id'=>$user->id])) {
                $user->setAssignmentFirst(Rbac::ROLE_OLYMPIC_OPERATOR);
            }
        });
        return $model;
    }

    public function edit(OlympicEditForm $form)
    {
        $user = $this->userRepository->get($form->managerId);
        $model = $this->repository->get($form->_olympic->id);
        $model->edit($form, $user->id);
        $this->transactionManager->wrap(function () use($user, $model) {
            $this->repository->save($model);
            if(!AuthAssignment::findOne(['user_id'=>$user->id, 'item_name'=>Rbac::ROLE_OLYMPIC_OPERATOR])) {
                $user->setAssignmentFirst(Rbac::ROLE_OLYMPIC_OPERATOR);
            }
        });
        $this->repository->save($model);
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }
}