<?php


namespace frontend\controllers\auth;

use common\forms\auth\ProfileForm;
use common\services\auth\ProfileService;
use yii\web\Controller;
use Yii;

class ProfileController extends Controller
{
    private $service;

    public function __construct($id, $module, ProfileService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * @return mixed
     */
    public function actionProfile()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $form = new ProfileForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->createOrEdit($form);
                Yii::$app->session->setFlash('success', 'Успешно добален/обновлен.');
                return $this->redirect(['profile']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('profile', [
            'model' => $form,
        ]);
    }
}