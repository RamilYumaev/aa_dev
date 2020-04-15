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
use olympic\repositories\OlimpicListRepository;
use olympic\repositories\OlympicRepository;
use yii\rbac\Role;

class OlympicService
{
    private $repository;
    private $transactionManager;
    private $userRepository;
    private $roleManager;
    private $olimpicListRepository;

    public function __construct(OlympicRepository $repository, OlimpicListRepository $olimpicListRepository,
                                TransactionManager $transactionManager, UserRepository $userRepository,
                                RoleManager $roleManager)
    {
        $this->repository = $repository;
        $this->roleManager = $roleManager;
        $this->transactionManager = $transactionManager;
        $this->userRepository = $userRepository;
        $this->olimpicListRepository = $olimpicListRepository;
    }

    public function create(OlympicCreateForm $form)
    {
        $user = $form->managerId ? $this->userRepository->get($form->managerId): null;
        $model = Olympic::create($form, $user ? $user->id: null);
        $this->transactionManager->wrap(function () use($user, $model) {
            $this->repository->save($model);
            if ($user){
                if (!AuthAssignment::findOne(['user_id' => $user->id])) {
                    $user->setAssignmentFirst(Rbac::ROLE_OLYMPIC_OPERATOR);
                }
            }
        });
        return $model;
    }

    public function edit(OlympicEditForm $form)
    {
        $user = $form->managerId ? $this->userRepository->get($form->managerId) : null;
        $model = $this->repository->get($form->_olympic->id);
        $model->edit($form, $user ? $user->id: null);
        $this->transactionManager->wrap(function () use($user, $model) {
            $this->repository->save($model);
            if ($user){
                if(!AuthAssignment::findOne(['user_id'=>$user->id, 'item_name'=>Rbac::ROLE_OLYMPIC_OPERATOR])) {
                    $user->setAssignmentFirst(Rbac::ROLE_OLYMPIC_OPERATOR);
                }
            }
        });
        $this->repository->save($model);
    }

    public function remove($id)
    {

        $model = $this->repository->get($id);
        if ($this->olimpicListRepository->isOlympicParent($model->id)) {
            throw new \DomainException('Вы не можете удалить олимпиаду, так как имеются дочерные записи');
        }
        $this->repository->remove($model);
    }
}