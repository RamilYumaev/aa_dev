<?php


namespace modules\entrant\controllers;
use common\helpers\FileHelper;
use dictionary\helpers\DictCompetitiveGroupHelper;
use kartik\mpdf\Pdf;
use modules\entrant\helpers\FileCgHelper;
use modules\entrant\helpers\PostDocumentHelper;
use modules\entrant\services\SubmittedDocumentsService;
use Mpdf\Mpdf;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use Yii;
use yii\web\NotFoundHttpException;


class PostDocumentController extends Controller
{
    private $service;

    public function __construct($id, $module, SubmittedDocumentsService $service, $config = [])
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
                    'send'=> ['POST']
                ],
            ],
        ];
    }
    public function beforeAction($action)
    {
        if(!PostDocumentHelper::isCorrectBlocks()) {
            Yii::$app->session->setFlash("error", "Заполните, пожалуйста, блоки, отмеченные красным цветом");
            Yii::$app->getResponse()->redirect(['abiturient/default/index']);
            Yii::$app->end();
        }
        try {
            return parent::beforeAction($action);
        } catch (BadRequestHttpException $e) {
        }
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @return mixed
     */
    public function actionOnline()
    {
        return $this->serviceSave(PostDocumentHelper::TYPE_ONLINE);
    }

    /**
     * @return mixed
     */
    public function actionMail()
    {
        return $this->serviceSave(PostDocumentHelper::TYPE_MAIL);
    }

    /**
     * @return mixed
     */
    public function actionVisit()
    {
        return $this->serviceSave(PostDocumentHelper::TYPE_VISIT);
    }

    /**
     * @return mixed
     */
    public function actionEcp()
    {
        return $this->serviceSave(PostDocumentHelper::TYPE_ECP);
    }

    public function actionSend() {
        try {
            $this->service->send(Yii::$app->user->identity->getId());
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }




    /**
     * @param integer $type
     * @return mixed
     */

    private function serviceSave($type) {

        try {
            $this->service->create($type, Yii::$app->user->identity->getId());
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }


}