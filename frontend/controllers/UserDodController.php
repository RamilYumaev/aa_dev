<?php


namespace frontend\controllers;

use dod\services\UserDodService;
use frontend\components\UserNoEmail;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;

class UserDodController extends Controller
{
    private $service;

    public function __construct($id, $module, UserDodService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
       return (new UserNoEmail())->redirect();
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionRegistration($id)
    {
        $this->isGuest();
        try {
            $this->service->add($id, Yii::$app->user->id);
            Yii::$app->session->setFlash('success', 'Спасибо за регистрацию.');
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['dod/index']);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->isGuest();
        try {
            $this->service->remove($id, Yii::$app->user->id);
            Yii::$app->session->setFlash('success', 'Успешно отменена');
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['dod/index']);
    }

    protected function isGuest() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['dod/index']);
        }
    }
}