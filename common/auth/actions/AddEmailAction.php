<?php
namespace common\auth\actions;
use common\auth\forms\SignupForm;
use common\auth\forms\UserEmailForm;
use common\auth\services\SignupService;
use common\helpers\FlashMessages;
use Yii;

class AddEmailAction extends \yii\base\Action
{
    private $viewPath = "@common/auth/actions/views/add-email";
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

        if (Yii::$app->user->isGuest || Yii::$app->user->identity->getEmail() ) {
            return $this->controller->goHome();
        }

        $form = new UserEmailForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->addEmail($form);
                Yii::$app->session->setFlash('success', 'Успешно обновлено.');
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