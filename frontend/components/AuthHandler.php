<?php


namespace frontend\components;




use common\auth\Identity;
use common\auth\models\Auth;
use common\auth\models\User;
use common\auth\repositories\AuthRepository;
use common\auth\repositories\UserRepository;
use common\transactions\TransactionManager;
use olympic\forms\auth\UserCreateForm;
use olympic\models\auth\Profiles;
use olympic\repositories\auth\ProfileRepository;
use yii\authclient\ClientInterface;
use yii\base\Exception;
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
    private $transaction;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
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
                Yii::$app->user->login(new Identity($user), 1);
            } else { // signup
                if ($email !== null && $this->userRepository->getByEmail($email)) {
                    Yii::$app->getSession()->setFlash('error', [
                        Yii::t('app', "Авторизация {client}. Пользователь с таким email уже существует.", ['client' => $this->client->getTitle()]),
                    ]);
                } else {
                    $this->transaction->wrap(function () use ($nickname, $email, $id) {
                        $user = $this->newUser($nickname, $email);
                        $this->userRepository->save($user);

                        $auth = $this->newAuth($user->id, $id);
                        $this->authRepository->save($auth);

                        $profile = Profiles::createDefault($user->id);
                        $this->profileRepository->save($profile);

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