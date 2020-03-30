<?php
namespace common\auth\actions;
use common\auth\forms\SignupForm;
use common\auth\services\SignupService;
use common\helpers\FlashMessages;
use Yii;

class SignUpAction extends \yii\base\Action
{
    private $viewPath = "@common/auth/actions/views/sign-up";
    private $service;

    public $role;

    public function __construct($id, $controller, SignupService $service, $config = [])
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

        $form = new SignupForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->signup($form, $this->role);
                return $this->controller->goHome();
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