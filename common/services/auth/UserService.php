<?php


namespace common\services\auth;


use common\forms\auth\UserCreateForm;
use common\forms\auth\UserEditForm;
use common\models\auth\User;
use common\repositories\UserRepository;
use common\transactions\TransactionManager;

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
        $user = User::create(
            $form->username,
            $form->email,
            $form->password
        );
        $this->transaction->wrap(function () use ($user, $form) {
            $this->repository->save($user);
            $user->setAssignment($form->role);
        });
        return $user;
    }

    public function edit($id, UserEditForm $form): void
    {
        $user = $this->repository->get($id);
        $user->edit(
            $form->username,
            $form->email
        );
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