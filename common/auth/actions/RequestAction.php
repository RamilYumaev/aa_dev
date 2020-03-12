<?php
namespace common\auth\actions;
use common\auth\forms\PasswordResetRequestForm;
use common\auth\services\PasswordResetService;
use Yii;

class RequestAction extends \yii\base\Action
{
    private $service;
    private $viewPath = "@common/auth/actions/views/request";

    public function __construct($id, $controller, PasswordResetService $service, $config = [])
    {
        parent::__construct($id, $controller, $config);
        $this->service = $service;


    }


    public function run()
    {
        $this->controller->viewPath = $this->viewPath;
        $this->controller->layout = "@frontend/views/layouts/loginRegister.php";

        $form = new PasswordResetRequestForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->request($form);
                Yii::$app->session->setFlash('success', 'Проверьте свою электронную почту и следуйте инструкциям, 
                указанным в письме.');
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