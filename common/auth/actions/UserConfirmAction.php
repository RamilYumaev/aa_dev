<?php
namespace common\auth\actions;
use common\auth\forms\SignupForm;
use common\auth\forms\UserEditForm;
use common\auth\forms\UserEmailForm;
use common\auth\models\User;
use common\auth\services\SignupService;
use common\helpers\FlashMessages;
use Yii;

class UserConfirmAction extends \yii\base\Action
{
    private $viewPath;
    private $service;


    public $role;

    public function __construct($id, $controller, SignupService $service, $config = [])
    {
        parent::__construct($id, $controller, $config);
        $this->service = $service;

    }

    public function run()
    {
        if (Yii::$app->user->isGuest) {
            return $this->controller->goHome();
        }
        try {
            $this->service->confirmDefault();
            Yii::$app->session->setFlash('success', FlashMessages::get()["successEmail"]);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->controller->redirect(Yii::$app->request->referrer);

    }

}