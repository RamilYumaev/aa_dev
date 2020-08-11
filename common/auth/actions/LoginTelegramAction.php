<?php

namespace common\auth\actions;

use common\auth\Identity;
use common\auth\models\Auth;
use common\auth\models\User;
use common\auth\rbac\Rbac;
use common\auth\repositories\AuthRepository;
use common\auth\repositories\UserRepository;
use common\transactions\TransactionManager;
use olympic\forms\auth\LoginForm;
use olympic\forms\auth\UserCreateForm;
use olympic\helpers\auth\ProfileHelper;
use olympic\models\auth\Profiles;
use olympic\repositories\auth\ProfileRepository;
use olympic\services\auth\AuthService;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\web\Response;

class LoginTelegramAction extends \yii\base\Action
{
    private $service;
    public $role;
    private $userRepository;
    private $profileRepository;
    private $authRepository;
    private $transactionManager;

    public function __construct($id, $controller, AuthService $service, $config = [])
    {
        parent::__construct($id, $controller, $config);
        $this->service = $service;
        $this->profileRepository = new ProfileRepository();
        $this->userRepository = new UserRepository();
        $this->authRepository = new AuthRepository();
        $this->transactionManager = new TransactionManager();
    }

    public function run()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $data=  Yii::$app->request->post();
        $this->handle($data);
        return ['data'=> '200'];
    }

    public function handle($data)
    {
        $attributes = $data;
        $telegramString = "telegram";
        $id = ArrayHelper::getValue($attributes, 'id');
        $auth = $this->authRepository->findBySourceAndSourceId($telegramString, $id);

        if (\Yii::$app->user->isGuest) {
            if ($auth) {
                $user = $this->userRepository->get($auth->user_id);
                $this->updateUserInfo($user, $attributes);
                $profile = $this->profileRepository->getUser($user->id);
                if ($profile->role !== $this->role) {
                    Yii::$app->getSession()->setFlash('error', 'У Вас нет прав для входа.');
                    return;
                }
                Yii::$app->user->login(new Identity($user), 1);
            } else { // signup
                $this->transactionManager->wrap(function () use ($telegramString, $id) {
                    $user = $this->newUser($id."@tg.com");
                    $user->status =10;
                    $this->userRepository->save($user);

                    $auth = $this->newAuth($user->id, $telegramString, $id);
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
    }

    private function newUser($nickname): User
    {
        $pass = Yii::$app->security->generateRandomString();
        $model = new UserCreateForm([ 'username' => $nickname, 'email' => $nickname, 'password' => $pass, 'role' =>1]);
        return User::create($model, $nickname);
    }

    private function newAuth($user_id,  $tel,  $id) : Auth
    {
        return  Auth::create($user_id, $tel, (string)$id);
    }

    /**
     * @param User $user
     * @param $data
     */
    private function updateUserInfo(User $user, $data)
    {
        $attributes = $data;
        $github = ArrayHelper::getValue($attributes, 'hask');
        if ($user->github === null && $github) {
            $user->github = $github;
            $this->userRepository->save($user);
        }
    }

}