<?php

namespace common\auth\services;

use aneeshikmat\yii2\Yii2TimerCountDown\Yii2TimerCountDown;
use common\auth\forms\DeclinationFioForm;
use common\auth\forms\SettingEmailCreateForm;
use common\auth\forms\SettingEmailEditForm;
use common\auth\models\DeclinationFio;
use common\auth\models\SettingEmail;
use common\auth\models\UserFirebaseToken;
use common\auth\models\UserSdoToken;
use common\auth\repositories\DeclinationFioRepository;
use common\auth\repositories\SettingEmailRepository;
use common\auth\repositories\UserFirebaseTokenRepository;
use common\auth\repositories\UserRepository;
use common\auth\repositories\UserSdoTokenRepository;

class UserTokensService
{
    private $userSdoTokenRepository;
    private $userFirebaseTokenRepository;

    public function __construct(
        UserSdoTokenRepository $userSdoTokenRepository,
        UserFirebaseTokenRepository $userFirebaseTokenRepository
    )
    {
        $this->userFirebaseTokenRepository = $userFirebaseTokenRepository;
        $this->userSdoTokenRepository = $userSdoTokenRepository;
    }

    public function getSdoToken($userId): UserSdoToken
    {
        $model = $this->userSdoTokenRepository->get($userId);
        if(!$model) {
            return $this->addSdoToken($userId);
        }
        return $model;
    }

    private function addSdoToken($userId) : UserSdoToken
    {
        $model = UserSdoToken::create($userId);
        $this->userSdoTokenRepository->save($model);
        return $model;
    }

    public function getFirebaseToken($userId, $token): UserFirebaseToken
    {
        $model = $this->userFirebaseTokenRepository->get($userId, $token);
        if(!$model) {
            return $this->addFirebaseToken($userId, $token);
        }
        return $model;
    }

    private function addFirebaseToken($userId, $token) : UserFirebaseToken
    {
        $model = UserFirebaseToken::create($userId, $token);
        $this->userFirebaseTokenRepository->save($model);
        return $model;
    }
}
