<?php


namespace modules\entrant\controllers\frontend;
use common\helpers\FileHelper;
use dictionary\helpers\DictCompetitiveGroupHelper;
use kartik\mpdf\Pdf;
use modules\entrant\helpers\FileCgHelper;
use modules\entrant\helpers\PdfHelper;
use modules\entrant\helpers\PostDocumentHelper;
use modules\entrant\services\SubmittedDocumentsService;
use Mpdf\Mpdf;
use yii\filters\AccessControl;
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
                    'send'=> ['POST'],
                    'record-send'=> ['POST']
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'send', 'mail', 'visit',  'record-send','online', 'ecp','consent-rejection', 'statement-rejection', 'rejection-record',],
                    'allow' => true,
                    'roles' => ['@'],
                        ],
                    [
                        'actions' => ['agreement-contract'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if(!PostDocumentHelper::isCorrectBlocks($this->getUserId())) {
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

    public function actionConsentRejection()
    {
        return $this->render('consent-rejection');
    }

    public function actionStatementRejection()
    {
        return $this->render('statement-rejection');
    }

    public function actionAgreementContract()
    {
        return $this->render('agreement-contract');
    }

    public function actionRejectionRecord()
    {
        return $this->render('rejection-record');
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
            $this->service->send($this->getUserId());
            return $this->redirect('/');
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionRecordSend() {
        try {
            $this->service->sendRecord($this->getUserId());
            return $this->redirect('/');
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }




    /**
     * @param integer $type
     * @return mixed
     */
    private function serviceSave($type) {

        try {
            $this->service->create($type, $this->getUserId());
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    private function getUserId()
    {
        return  Yii::$app->user->identity->getId();
    }

    /**
     *
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */

    public function actionPdf()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'image/jpeg');

        $content = $this->renderPartial('pdf/_main', ['userId' => $this->getUserId()]);
        $pdf = PdfHelper::generate($content, 'Расписка.pdf');
        $render = $pdf->render();

        return $render;
    }
}