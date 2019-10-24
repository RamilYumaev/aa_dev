<?php


namespace olympic\services\auth;


use olympic\forms\auth\UserCreateForm;
use olympic\forms\auth\UserEditForm;
use olympic\models\auth\User;
use olympic\repositories\auth\UserRepository;
use olympic\transactions\TransactionManager;

class UserService
{
    private $repository;
    private $transaction;

    public function __construct(
        UserRepository $repository,
        TransactionManager $transaction
    )
    {
        $this->repository = $repository;
        $this->transaction = $transaction;
    }

    public function create(UserCreateForm $form): User
    {
        $user = User::create($form);
        $this->transaction->wrap(function () use ($user, $form) {
            $this->repository->save($user);
            $user->setAssignment($form->role);
        });
        return $user;
    }

    public function edit($id, UserEditForm $form): void
    {
        $user = $this->repository->get($id);
        $user->edit($form);
        $this->transaction->wrap(function () use ($user, $form) {
            $this->repository->save($user);
            $user->setAssignment($form->role);
        });
    }

    public function remove($id): void
    {
        $user = $this->repository->get($id);
        $this->repository->remove($user);
    }

}