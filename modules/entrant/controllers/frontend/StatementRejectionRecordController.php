<?php


namespace modules\entrant\controllers\frontend;
use modules\entrant\helpers\FileCgHelper;
use modules\entrant\helpers\PdfHelper;
use modules\entrant\models\StatementConsentCg;
use modules\entrant\models\StatementRejectionCgConsent;
use modules\entrant\models\StatementRejectionRecord;
use modules\entrant\services\StatementConsentCgService;
use modules\entrant\services\StatementRejectionRecordService;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class  StatementRejectionRecordController extends Controller
{
    private $service;

    public function __construct($id, $module, StatementRejectionRecordService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionCreate($id)
    {
        try {
            $this->service->create($id, $this->getUser());
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     *
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */

    public function actionPdf($id)
    {
        $statementRejection = $this->findModel($id);
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'image/jpeg');

        $content = $this->renderPartial('pdf/_main', ["statementRejection" =>  $statementRejection  ]);
        $pdf = PdfHelper::generate($content, FileCgHelper::fileNameRejectionRecord( ".pdf"));
        $render = $pdf->render();

        try {
            $this->service->addCountPages($id, count($pdf->getApi()->pages));
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $render;
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): StatementRejectionRecord
    {
        if (($model = StatementRejectionRecord::find()->andWhere(['id'=>$id, 'user_id'=> $this->getUser()])->one()) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }


    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
         $this->findModel($id);
        try {
            $this->service->remove($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionGet($id)
    {
        $model = $this->findModel($id);
        $filePath = $model->getUploadedFilePath('pdf_file');
        if (!file_exists($filePath)) {
            throw new NotFoundHttpException('Запрошенный файл не найден.');
        }
        return Yii::$app->response->sendFile($filePath);
    }



    private function  getUser() {
       return Yii::$app->user->identity->getId();
    }


}