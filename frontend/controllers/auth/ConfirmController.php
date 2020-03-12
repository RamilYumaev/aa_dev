<?php

namespace frontend\controllers\auth;

use common\auth\services\OlympicConfirmService;
use olympic\services\UserOlimpiadsService;
use olympic\services\UserSchoolService;
use yii\web\Controller;
use Yii;

class ConfirmController extends Controller
{
    private $service;
    private $schoolService;
    private $olimpiadsService;

    public function __construct($id, $module, OlympicConfirmService $service, UserSchoolService $schoolService, UserOlimpiadsService $olimpiadsService,  $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->schoolService = $schoolService;
        $this->olimpiadsService = $olimpiadsService;
    }

    /**
     * @param $token
     * @param $olympic_id
     * @return mixed
     */

    public function actionIndex($token, $olympic_id)
    {
        try {
            $this->service->confirmOlympic($token, $olympic_id);
            Yii::$app->session->addFlash('success', 'Ваш адрес электронной почты подтвержден.');
            return $this->redirect(['account/login']);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->goHome();
    }

    /**
     * @param $hash
     * @return mixed
     */

    public function actionTeacher($hash)
    {
        try {
            $this->schoolService->confirm($hash);
            Yii::$app->session->addFlash('success', 'Спасибо за подтверждение.');
            return $this->goHome();
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->goHome();
    }

    /**
     * @param $hash
     * @return mixed
     */

    public function actionTeacherUser($hash)
    {
        try {
            $this->olimpiadsService->confirm($hash);
            Yii::$app->session->addFlash('success', 'Спасибо за подтверждение.');
            return $this->goHome();
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->goHome();
    }

}