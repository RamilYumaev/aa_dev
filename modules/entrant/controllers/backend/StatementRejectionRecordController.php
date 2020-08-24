<?php

namespace modules\entrant\controllers\backend;

use modules\dictionary\models\JobEntrant;
use modules\entrant\helpers\FileCgHelper;
use modules\entrant\helpers\PdfHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\StatementConsentCg;
use modules\entrant\models\StatementRejectionRecord;
use modules\entrant\readRepositories\StatementReadConsentRepository;
use modules\entrant\searches\StatementConsentSearch;
use modules\entrant\searches\StatementRejectionRecordSearch;
use modules\entrant\services\StatementConsentCgService;
use modules\entrant\services\StatementRejectionRecordService;
use yii\helpers\Json;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class StatementRejectionRecordController extends Controller
{
    private $service;

    public function __construct($id, $module, StatementRejectionRecordService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }


    public function actionIndex($status = null)
    {
        $searchModel = new StatementRejectionRecordSearch($status);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * @param $id
     * @param $status
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionStatus($id, $status)
    {
        $this->findModel($id);
        try {
            $this->service->status($id, $status);
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
        $statementRejection= $this->findModel($id);
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'image/jpeg');

        $content = $this->renderPartial('@modules/entrant/views/frontend/statement-rejection-record/pdf/_main', ["statementRejection" => $statementRejection ]);
        $pdf = PdfHelper::generate($content, FileCgHelper::fileNameRejectionRecord( ".pdf"));
        $render = $pdf->render();
        return $render;
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): StatementRejectionRecord
    {
        if (($model = StatementRejectionRecord::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }



}