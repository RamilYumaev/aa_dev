<?php

namespace common\auth\actions;

use common\auth\Identity;
use olympic\forms\auth\LoginForm;
use olympic\services\auth\AuthService;
use Yii;

class LoginAction extends \yii\base\Action
{
    private $viewPath = "@common/auth/actions/views/login";
    private $service;
    public $role;

    public function __construct($id, $controller, AuthService $service, $config = [])
    {
        parent::__construct($id, $controller, $config);
        $this->service = $service;

    }

    public function run()
    {
        $this->controller->viewPath = $this->viewPath;
        $this->controller->layout = "@frontend/views/layouts/loginRegister.php";
        if (!Yii::$app->user->isGuest) {
            return $this->controller->goHome();
        }
        $form = new LoginForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $user = $this->service->auth($form, $this->role);
                Yii::$app->user->login(new Identity($user), $form->rememberMe ? Yii::$app->params['user.rememberMeDuration'] : 0);
                return $this->controller->goBack();
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->controller->render('index', [
            'model' => $form,
        ]);
    }

}