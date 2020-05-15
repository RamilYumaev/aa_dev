<?php


namespace modules\entrant\controllers;
use kartik\mpdf\Pdf;
use modules\entrant\helpers\FileCgHelper;
use modules\entrant\models\StatementConsentPersonalData;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\services\StatementIndividualAchievementsService;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;


class StatementPersonalDataController extends Controller
{
    private $service;

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

        $content = $this->renderPartial('pdf/_main', ["statementPd" => $statementPd ]);
        $pdf = $this->generatePdf($content);
        $render = $pdf->render();

        return $render;

    }

    private function generatePdf($content) {

        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_UTF8,
            'filename' => FileCgHelper::fileNamePD('.pdf'),
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            'marginLeft' => 25,
            'marginRight' => 15,
            'marginTop' => 15,
            'marginBottom' => 15,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
           // 'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.css',
            'cssFile' => '@frontend/web/css/pdf-documents.css',
            'defaultFont' => 'Times New Roman',
            'defaultFontSize'=> 9, //pt
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            // call mPDF methods on the fly
            //'marginTop' => 40,
            'methods' => [
            ]
        ]);
        return $pdf;
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): StatementConsentPersonalData
    {
        if (($model = StatementConsentPersonalData::findOne(['id'=>$id, 'user_id' => Yii::$app->user->identity->getId()])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }


}