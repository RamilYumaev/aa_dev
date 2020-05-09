<?php
namespace common\auth\actions;
use common\auth\forms\SignupForm;
use common\auth\forms\UserEditForm;
use common\auth\forms\UserEmailForm;
use common\auth\models\User;
use common\auth\services\SignupService;
use common\helpers\FlashMessages;
use Yii;

class UserEditAction extends \yii\base\Action
{
    private $viewPath = "@common/auth/actions/views/user-edit";
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

        if (Yii::$app->user->isGuest) {
            return $this->controller->goHome();
        }

        $form = new UserEditForm(User::findOne(Yii::$app->user->identity->getId()));
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($form);
                Yii::$app->session->setFlash('success', 'Успешно обновлено.');
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