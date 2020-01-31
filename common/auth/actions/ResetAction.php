<?php
namespace common\auth\actions;
use common\auth\forms\PasswordResetRequestForm;
use common\auth\services\PasswordResetService;
use Yii;
use yii\web\BadRequestHttpException;

class ResetAction extends \yii\base\Action
{
    private $service;
    private $viewPath = "@common/auth/actions/views/reset";
    private $token;

    public function __construct($id, $controller, PasswordResetService $service, $config = [])
    {
        parent::__construct($id, $controller, $config);
        $this->service = $service;
        $this->token = Yii::$app->request->get('token');

    }

    /**
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function run()
    {
        $this->controller->viewPath = $this->viewPath;
        $this->controller->layout = "@frontend/views/layouts/loginRegister.php";
        try {
            $this->service->validateToken($this->token);
        } catch (\DomainException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        $form = new \common\auth\forms\ResetPasswordForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->reset($this->token, $form);
                Yii::$app->session->setFlash('success', 'Пароль изменен!');
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->controller->goHome();
        }

        return $this->controller->render('index', [
            'model' => $form,
        ]);
    }

}