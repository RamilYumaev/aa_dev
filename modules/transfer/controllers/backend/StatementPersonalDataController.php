<?php


namespace modules\transfer\controllers\backend;
use kartik\mpdf\Pdf;
use modules\entrant\helpers\FileCgHelper;
use modules\entrant\helpers\PdfHelper;
use modules\transfer\models\StatementConsentPersonalData;
use modules\entrant\services\StatementPersonalDataService;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;


class StatementPersonalDataController extends Controller
{
    /**
     *
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */

    public function actionPdf($id)
    {
        $statementPd= $this->findModel($id);
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'image/jpeg');
        $content = $this->renderPartial('@modules/transfer/views/frontend/statement-personal-data/pdf/_main', ["statementPd" => $statementPd]);
        $pdf = PdfHelper::generate($content, FileCgHelper::fileNamePD('.pdf'));
        $render = $pdf->render();
        try {
            $statementPd->setCountPages($pdf->getApi()->pages);
            $statementPd->save();
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
    protected function findModel($id): StatementConsentPersonalData
    {
        if (($model = StatementConsentPersonalData::findOne(['id'=>$id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }


}