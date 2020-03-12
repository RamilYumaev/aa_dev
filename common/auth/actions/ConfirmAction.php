<?php
namespace common\auth\actions;
use common\auth\forms\SignupForm;
use common\auth\services\SignupService;
use common\helpers\FlashMessages;
use Yii;

class ConfirmAction extends \yii\base\Action
{
    private $service;
    private $token;

    public function __construct($id, $controller, SignupService $service, $config = [])
    {
        parent::__construct($id, $controller, $config);
        $this->service = $service;
        $this->token = Yii::$app->request->get('token');
    }

    public function run()
    {
        try {
            $user = $this->service->confirm($this->token);
            Yii::$app->session->setFlash('success', 'Ваш адрес электронной почты подтвержден.');
            return $this->controller->redirect(['account/login']);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->controller->goHome();
    }

}