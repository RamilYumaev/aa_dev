<?php


namespace modules\entrant\controllers;

use modules\entrant\forms\AddressForm;
use modules\entrant\helpers\PostDocumentHelper;
use modules\entrant\models\Address;
use modules\entrant\services\AddressService;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class PostDocumentController extends Controller
{
    private $service;

    public function __construct($id, $module, AddressService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'online' => ['POST'],
                    'visit' => ['POST'],
                    'mail' => ['POST'],
                    'ecp' => ['POST'],
                ],
            ],
        ];
    }
    public function beforeAction($action)
    {
        if(!PostDocumentHelper::isCorrectBlocks()) {
            Yii::$app->session->setFlash("error", "Не заполнены некоторые блоки");
            Yii::$app->getResponse()->redirect(['abiturient/default/index']);
            Yii::$app->end();
        }
        try {
            return parent::beforeAction($action);
        } catch (BadRequestHttpException $e) {
        }
    }

    /**
     * @return mixed
     */
    public function actionOnline()
    {

    }

    /**
     * @return mixed
     */
    public function actionMail()
    {

    }

    /**
     * @return mixed
     */
    public function actionVisit()
    {

    }


    /**
     * @return mixed
     */
    public function actionEcp()
    {

    }
}