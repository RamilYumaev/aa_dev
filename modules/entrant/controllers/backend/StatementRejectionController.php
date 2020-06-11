<?php


namespace modules\entrant\controllers\backend;
use modules\entrant\helpers\FileCgHelper;
use modules\entrant\helpers\PdfHelper;
use modules\entrant\models\StatementRejection;
use modules\entrant\models\StatementRejectionCg;
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
        $content = $this->renderPartial('@modules/entrant/views/frontend/statement-rejection/pdf/_main', ["statementRejection" => $statementRejection,]);
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
        $statementRejection = $this->findModelCg($id);
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'image/jpeg');
        $content = $this->renderPartial('@modules/entrant/views/frontend/statement-rejection/pdf/_main_cg', ["statementRejection" => $statementRejection]);
        $pdf = PdfHelper::generate($content, FileCgHelper::fileNameRejection('.pdf'));
        $render = $pdf->render();

        try {
            $this->service->addCountPagesCg($statementRejection->id, count($pdf->getApi()->pages));
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
        $content = $this->renderPartial('@modules/entrant/views/frontend/statement-rejection/pdf/_main_consent', ["statementConsent" => $statementConsent]);
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
        if (($model = StatementRejection::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModelCg($id): StatementRejectionCg
    {
        if (($model = StatementRejectionCg::findOne($id)) !== null) {
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
        if (($model = StatementRejectionCgConsent::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }

}