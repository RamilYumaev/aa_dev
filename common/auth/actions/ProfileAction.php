<?php


namespace common\auth\actions;

use olympic\forms\auth\ProfileEditForm;
use Yii;
use olympic\services\auth\ProfileService;

class ProfileAction extends \yii\base\Action
{
    private $viewPath = "@common/auth/actions/views/profile";
    public $view = 'profile-default';
    private $service;

    public function __construct($id, $controller, ProfileService $service, $config = [])
    {
        parent::__construct($id, $controller, $config);
        $this->service = $service;
    }

    public function run()
    {
        $this->controller->viewPath = $this->viewPath;
        if (Yii::$app->user->isGuest) {
            return $this->controller->goHome();
        }

        $form = new ProfileEditForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($form);
                Yii::$app->session->setFlash('success', 'Успешно обновлен.');
                return $this->controller->redirect(['edit']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->controller->render($this->view, [
            'model' => $form,
        ]);
    }

}