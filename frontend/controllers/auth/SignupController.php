<?php

namespace frontend\controllers\auth;

use common\auth\forms\SignupForm;
use common\auth\forms\UserEmailForm;
use common\auth\services\SignupService;
use common\helpers\FlashMessages;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;

class SignupController extends Controller
{

    private $service;

    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function __construct($id, $module, SignupService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionRequest()
    {
        $this->layout = "@frontend/views/layouts/loginRegister.php";

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $form = new SignupForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->signup($form);
                Yii::$app->session->setFlash('success', FlashMessages::get()["successRegistration"]);
                return $this->goHome();
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('request', [
            'model' => $form,
        ]);
    }

    /**
     * @return mixed
     */
    public function actionAddEmail()
    {
        $this->layout = "@frontend/views/layouts/loginRegister.php";

        if (Yii::$app->user->isGuest || Yii::$app->user->identity->getEmail() ) {
            return $this->goHome();
        }

        $form = new UserEmailForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->addEmail($form);
                Yii::$app->session->setFlash('success', 'Успешно обновлено.');
                return $this->goHome();
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('add-email', [
            'model' => $form,
        ]);
    }

    /**
     * @param $token
     * @return mixed
     */
    public function actionConfirm($token)
    {
        try {
            $user = $this->service->confirm($token);
            Yii::$app->session->setFlash('success', 'Ваш адрес электронной почты подтвержден.');
            return $this->redirect(['auth/auth/login']);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->goHome();
    }


    /**
     * @param $token
     * @param $olympic_id
     * @return mixed
     */

    public function actionConfirmOlympic($token, $olympic_id)
    {
        try {
            $this->service->confirmOlympic($token, $olympic_id);
            Yii::$app->session->addFlash('success', 'Ваш адрес электронной почты подтвержден.');
            return $this->redirect(['auth/auth/login']);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->goHome();
    }



}