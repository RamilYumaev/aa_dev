<?php
namespace olympic\services\auth;

use common\sending\traits\SelectionCommitteeMailTrait;
use frontend\search\Profile;
use olympic\forms\auth\UserCreateForm;
use olympic\forms\auth\UserEditForm;
use common\auth\models\User;
use common\auth\repositories\UserRepository;
use common\transactions\TransactionManager;
use olympic\models\auth\Profiles;
use olympic\repositories\auth\ProfileRepository;
use yii\db\Exception;

class UserService
{
    private $repository;
    private $transaction;
    private $profileRepository;

    use SelectionCommitteeMailTrait;

    public function __construct(
        UserRepository $repository,
        TransactionManager $transaction,
        ProfileRepository $profileRepository
    )
    {
        $this->profileRepository = $profileRepository;
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

    public function addToken($id, $result)
    {
        $user = $this->repository->get($id);
        $user->setAisToken($result);
        $this->repository->save($user);
    }

    /**
     * @param Profile $form
     * @return User
     * @throws Exception
     * @throws \yii\base\Exception
     */
    public function createByOperator(Profile $form): User
    {
        $is = $this->repository->getEmail($form->email);
        if($is){
            throw new Exception('Такая электорнная почта существует в базе данных');
        }
        $string = \Yii::$app->security->generateRandomString(8);
        $user = User::createByOperator($form, $string);
        $this->transaction->wrap(function () use ($user,$form) {
            $this->repository->save($user);
            $profile = Profiles::createDefault($user->id);
            $profile->save(false);
        });

        $configTemplate =  ['html' => 'newPassEntrant-html', 'text' => 'newPassEntrant-text'];
        $configData = ['user' => $user, 'string' => $string];
        $this->sendEmail($user, $configTemplate, $configData, "Создание личного кабинета!");
        return $user;
    }

    public function remove($id): void
    {
        $user = $this->repository->get($id);
        $this->repository->remove($user);
    }

}