<?php


namespace modules\transfer\controllers\frontend;
use kartik\mpdf\Pdf;
use modules\entrant\helpers\FileCgHelper;
use modules\entrant\helpers\PdfHelper;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementConsentPersonalData;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\services\StatementIndividualAchievementsService;
use modules\entrant\services\StatementPersonalDataService;
use modules\transfer\models\PacketDocumentUser;
use modules\transfer\models\StatementTransfer;
use modules\transfer\models\TransferMpgu;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;


class StatementTransferController extends Controller
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
        $statement= $this->findModel($id);
        if(!$statement->transferMpgu->insideMpgu()) {
            $this->isPacketDocument();
        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'image/jpeg');
        $content = $this->renderPartial('pdf/_main', ["statement" => $statement]);
        $pdf = PdfHelper::generate($content, "Заявление.pdf");
        $render = $pdf->render();
        try {
            $statement->setCountPages(count($pdf->getApi()->pages));
            $statement->save();
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $render;
    }

    protected function isPacketDocument() {
        /** @var PacketDocumentUser $pack */
        foreach (PacketDocumentUser::find()->andWhere(['user_id' =>  Yii::$app->user->identity->getId()])->all() as $pack) {
            if (!$pack->isBook() && $pack->isNullData()) {
                Yii::$app->session->setFlash('warning', 'Отсутствуют данные "'.$pack->getTypeNameR().'"');
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
    }
    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): StatementTransfer
    {
        if (($model = StatementTransfer::findOne(['id'=> $id, 'user_id' => Yii::$app->user->identity->getId()])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }
}