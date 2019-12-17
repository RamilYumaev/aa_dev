<?php

namespace operator\controllers\auth;

use common\auth\forms\SettingEmailForm;
use common\auth\Identity;
use common\auth\services\SettingEmailService;
use olympic\forms\auth\LoginForm;
use olympic\services\auth\AuthService;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;

class SettingEmailController extends \yii\web\Controller
{
    private $service;

    public function __construct($id, $module, SettingEmailService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * @return mixed
     */
    public function actionSetting()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $form = new SettingEmailForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->create($form);
                Yii::$app->session->setFlash('success', "Успешно сохранено");
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('setting', [
            'model' => $form,
        ]);
    }


}