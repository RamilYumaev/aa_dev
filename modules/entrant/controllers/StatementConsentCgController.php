<?php


namespace modules\entrant\controllers;
use modules\entrant\helpers\FileCgHelper;
use modules\entrant\helpers\PdfHelper;
use modules\entrant\models\StatementConsentCg;
use modules\entrant\services\StatementConsentCgService;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class StatementConsentCgController extends Controller
{
    private $service;

    public function __construct($id, $module, StatementConsentCgService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
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
        return $this->redirect(['default/index']);
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
        $statementConsent= $this->findModel($id);
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'image/jpeg');

        $content = $this->renderPartial('pdf/_main', ["statementConsent" => $statementConsent ]);
        $pdf = PdfHelper::generate($content, FileCgHelper::fileNameConsent());
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
    protected function findModel($id): StatementConsentCg
    {
        if (($model = StatementConsentCg::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }

    private function  getUser() {
       return Yii::$app->user->identity->getId();
    }


}