<?php
namespace modules\transfer\controllers\frontend;

use modules\entrant\forms\FileForm;
use modules\entrant\helpers\FileHelper;
use modules\transfer\models\File;
use modules\entrant\services\FileService;
use modules\transfer\models\StatementTransfer;
use yii\bootstrap\ActiveForm;
use yii\db\BaseActiveRecord;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class FileController extends Controller
{
    private $service;

    public function __construct($id, $module, FileService $service, $config = [])
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @param integer $id
     * @param $hash
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionGet($id, $hash)
    {
        $modelName = FileHelper::validateModel($hash);
        $model = $this->findModel($id, $modelName);
        $filePath = $model->getUploadedFilePath('file_name_user');
        if (!file_exists($filePath)) {
            throw new NotFoundHttpException('Запрошенный файл не найден.');
        }
        return Yii::$app->response->sendFile($filePath);
    }


    /**
     * @param $hash
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionUpload($hash, $id)
    {
        $model = FileHelper::validateModel($hash);
        $modelOne = $this->model($model, $id);
        if ($model == StatementTransfer::class && !$modelOne->count_pages) {
            Yii::$app->session->setFlash("danger", "Вы не скачали файл pdf.");
            return $this->redirect(Yii::$app->request->referrer);
        }

        $form = new File();
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $model = $this->service->create($form, $modelOne);
                $link = $model ? $model->hashId : "";
                return $this->redirect(Yii::$app->request->referrer . $link);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('@modules/entrant/views/frontend/file/download', [
            'model' => $form,
        ]);
    }

    /**
     * @param $hash
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionUpdate($hash, $id)
    {
        $model = FileHelper::validateModel($hash);
        $file = $this->findModel($id, $model);
        $form = new FileForm($file->user_id, $file);
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($file->id, $form);
                $link = $file ? $file->hashId : "";
                return $this->redirect(Yii::$app->request->referrer . $link);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('download', [
            'model' => $form,
        ]);
    }


    /**
     * @param integer $id
     * @param $model
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id, $model): File
    {
        if (($model = File::findOne(['id' => $id, 'model' => $model, 'user_id' => $this->getUser()])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }

    /**
     * @param integer $id
     * @param integer $modelOne
     * @return mixed
     * @throws NotFoundHttpException
     * @var $model BaseActiveRecord;
     */
    protected function model($modelOne, $id): BaseActiveRecord
    {
        if ($modelOne == StatementConsentCg::class && (($model = $modelOne::find()->statementOne($id, $this->getUser())) !== null)) {
            return $model;
        }
        if ($modelOne == StatementRejectionCg::class && (($model = $modelOne::find()->statementOne($id, $this->getUser())) !== null)) {
            return $model;
        }
        if ($modelOne == StatementRejection::class && (($model = $modelOne::find()->statementOne($id, $this->getUser())) !== null)) {
            return $model;
        }
        if ($modelOne == StatementRejectionCgConsent::class && (($model = $modelOne::find()->statementOne($id, $this->getUser())) !== null)) {
            return $model;
        }
        if ($modelOne == StatementAgreementContractCg::class && (($model = $modelOne::find()->statementOne($id, $this->getUser())) !== null)) {
            return $model;
        }
        if ($modelOne == ReceiptContract::class && (($model = $modelOne::find()->receiptOne($id, $this->getUser())) !== null)) {
            return $model;
        }
        if ($modelOne && (($model = $modelOne::findOne(['id' => $id, 'user_id' => $this->getUser()])) !== null)) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }

    private function getUser()
    {
        return Yii::$app->user->identity->getId();
    }

    /**
     * @param integer $id
     * @param $hash
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionDelete($id, $hash)
    {
        $modelName = FileHelper::validateModel($hash);
        $model = $this->findModel($id, $modelName);
        $hashId = $model->hashId;
        try {
            $this->service->remove($model->id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer . $hashId);
    }
}