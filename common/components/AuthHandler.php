<?php

namespace common\components;

use common\auth\Identity;
use common\auth\models\Auth;
use common\auth\models\User;
use common\auth\rbac\Rbac;
use common\auth\repositories\AuthRepository;
use common\auth\repositories\UserRepository;
use common\transactions\TransactionManager;
use olympic\forms\auth\UserCreateForm;
use olympic\helpers\auth\ProfileHelper;
use olympic\models\auth\AuthAssignment;
use olympic\models\auth\Profiles;
use olympic\repositories\auth\ProfileRepository;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;
use Yii;

class AuthHandler
{
    /**
     * @var ClientInterface
     */
    private $client;
    private $userRepository;
    private $profileRepository;
    private $authRepository;
    private $transactionManager;
    private $role;

    public function __construct(ClientInterface $client, $role)
    {
        $this->client = $client;
        $this->role = $role;
        $this->profileRepository = new ProfileRepository();
        $this->userRepository = new UserRepository();
        $this->authRepository = new AuthRepository();
        $this->transactionManager = new TransactionManager();
    }

    public function handle()
    {
        $attributes = $this->client->getUserAttributes();
        $email = ArrayHelper::getValue($attributes, 'email');
        $id = ArrayHelper::getValue($attributes, 'id');
        $nickname = ArrayHelper::getValue($attributes, 'login');
        $auth = $this->authRepository->findBySourceAndSourceId($this->client->getId(), $id);

        if (\Yii::$app->user->isGuest) {
            if ($auth) {
                $user = $this->userRepository->get($auth->user_id);
                $this->updateUserInfo($user);
                $profile = $this->profileRepository->getUser($user->id);
                if ($profile->role !== $this->role) {
                    Yii::$app->getSession()->setFlash('error', 'У Вас нет прав для входа.');
                    return;
                }
                Yii::$app->user->login(new Identity($user), 1);
            } else { // signup
                if ($email !== null && $this->userRepository->getEmail($email)) {
                    Yii::$app->getSession()->setFlash('error', [
                        Yii::t('app', "Авторизация {client}. Пользователь с таким email уже существует.", ['client' => $this->client->getTitle()]),
                    ]);
                }
                elseif ($nickname  !== null && $this->userRepository->getUsername($nickname)) {
                        Yii::$app->getSession()->setFlash('error', [
                            Yii::t('app', "Авторизация {client}. Пользователь с таким логином уже существует.", ['client' => $this->client->getTitle()]),
                        ]);
                } else {
                    $this->transactionManager->wrap(function () use ($nickname, $email, $id) {
                        $user = $this->newUser($nickname ?? $id, $email);
                        $this->userRepository->save($user);

                        $auth = $this->newAuth($user->id, $id);
                        $this->authRepository->save($auth);

                        $profile = Profiles::createDefault($user->id);
                        $profile->setRole($this->role);
                        $this->profileRepository->save($profile);

                        if($this->role !== ProfileHelper::ROLE_STUDENT) {
                            $user->setAssignmentFirst(Rbac::roleName($this->role));
                        }
                        Yii::$app->user->login(new Identity($user), 1);
                    });
                }
            }
        } else { // user already logged in
            if (!$auth) { // add auth provider
                $auth = $this->newAuth(Yii::$app->user->id, (string)$attributes['id']);
                $this->authRepository->save($auth);
                $user = $this->userRepository->get($auth->user_id);
                $this->updateUserInfo($user);
            } else { // there's existing auth
                Yii::$app->getSession()->setFlash('error', [
                    Yii::t('app',
                        'Unable to link {client} account. There is another user using it.',
                        ['client' => $this->client->getTitle()]),
                ]);
            }
        }
    }

    private function newUser($nickname, $email): User
    {
        $pass = Yii::$app->security->generateRandomString();
        $model = new UserCreateForm([ 'username' => $nickname, 'email' => $email, 'password' => $pass, 'role' =>1]);
        return User::create($model, $nickname);
    }

    private function newAuth($user_id, $id) : Auth
    {
      return  Auth::create($user_id, $this->client->getId(), (string)$id);
    }

    /**
     * @param User $user
     */
    private function updateUserInfo(User $user)
    {
        $attributes = $this->client->getUserAttributes();
        $github = ArrayHelper::getValue($attributes, 'login');
        if ($user->github === null && $github) {
            $user->github = $github;
            $this->userRepository->save($user);
        }
    }
}