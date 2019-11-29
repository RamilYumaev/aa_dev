<?php


namespace frontend\controllers;

use common\helpers\FlashMessages;
use frontend\components\UserNoEmail;
use olympic\models\OlimpicList;
use olympic\services\UserOlimpiadsService;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;
use yii\web\HttpException;

class UserOlympicController extends Controller
{
    private $service;

    public function __construct($id, $module, UserOlimpiadsService $service,  $config = [])
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
            Yii::$app->session->setFlash('success', FlashMessages::get()["successRegistration"]);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
          return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->isGuest();
        try {
            $this->service->remove($id);
            Yii::$app->session->setFlash('success', 'Успешно отменена');
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    protected function isGuest() {
        if (Yii::$app->user->isGuest) {
            throw new HttpException("403", "Вы не авторизованы!");
        }
    }
}