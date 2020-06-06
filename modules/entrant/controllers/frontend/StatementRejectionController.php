<?php


namespace modules\entrant\controllers\frontend;
use modules\entrant\helpers\FileCgHelper;
use modules\entrant\helpers\PdfHelper;
use modules\entrant\models\StatementCg;
use modules\entrant\models\StatementRejection;
use modules\entrant\models\StatementRejectionCgConsent;
use modules\entrant\services\StatementService;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;


class StatementRejectionController extends Controller
{
    private $service;

    public function __construct($id, $module, StatementService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
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
        $statementRejection = $this->findModelRejection($id);
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'image/jpeg');
        $content = $this->renderPartial('pdf/_main', ["statementRejection" => $statementRejection,]);
        $pdf = PdfHelper::generate($content, FileCgHelper::fileNameRejection('.pdf'));
        $render = $pdf->render();

        try {
            $this->service->addCountPagesRejection($statementRejection->id, count($pdf->getApi()->pages));
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }


        return $render;

    }

    /**
     *
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */

    public function actionPdfCg($id)
    {
        $statementCg = $this->findModelCg($id);
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'image/jpeg');
        $content = $this->renderPartial('pdf/_main_cg', ["statementCg" => $statementCg]);
        $pdf = PdfHelper::generate($content, FileCgHelper::fileNameRejection('.pdf'));
        $render = $pdf->render();

        try {
            $this->service->addCountPagesCg($statementCg->id, count($pdf->getApi()->pages));
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $render;
    }



    /**
     *
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */

    public function actionPdfConsent($id)
    {
        $statementConsent = $this->findModelConsent($id);
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'image/jpeg');
        $content = $this->renderPartial('pdf/_main_consent', ["statementConsent" => $statementConsent]);
        $pdf = PdfHelper::generate($content, FileCgHelper::fileNameRejection('.pdf'));
        $render = $pdf->render();

        try {
            $this->service->addCountPagesConsent($statementConsent->id, count($pdf->getApi()->pages));
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
    protected function findModelRejection($id): StatementRejection
    {
        if (($model = StatementRejection::find()->statementOne($id, Yii::$app->user->identity->getId())) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModelCg($id): StatementCg
    {
        if (($model = StatementCg::find()->statementOne($id, Yii::$app->user->identity->getId())) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModelConsent($id): StatementRejectionCgConsent
    {
        if (($model = StatementRejectionCgConsent::find()->statementOne($id, Yii::$app->user->identity->getId())) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }

}