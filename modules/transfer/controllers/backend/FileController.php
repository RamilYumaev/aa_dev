<?php
namespace modules\transfer\controllers\backend;

use modules\dictionary\models\JobEntrant;
use modules\entrant\forms\FileMessageForm;
use modules\entrant\helpers\FileHelper;
use modules\transfer\models\File;
use modules\entrant\searches\FileSearch;
use modules\transfer\models\PassExamProtocol;
use modules\transfer\models\PassExamStatement;
use modules\transfer\models\StatementConsentPersonalData;
use modules\transfer\models\StatementTransfer;
use modules\transfer\services\FileService;
use modules\transfer\services\SubmittedDocumentsService;
use yii\bootstrap\ActiveForm;;

use yii\db\BaseActiveRecord;
use yii\helpers\FileHelper as IfFile;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

class FileController extends Controller
{
    private $submittedDocumentsService;
    private $service;
    public function __construct($id, $module, FileService $service,  SubmittedDocumentsService $submittedDocumentsService,  $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->submittedDocumentsService = $submittedDocumentsService;
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


    /* @return  JobEntrant*/
    protected function getJobEntrant() {
        return Yii::$app->user->identity->jobEntrant();
    }


    /**
     * @param $hash
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionMessage($hash, $id)
    {
        $model = FileHelper::validateModel($hash);
        $form = $this->findModel($id, $model);
        $form->setScenario(File::UPDATE);
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->addMessage($form->id, $form);
                $link = $form ? $form->hashId : "";
                return $this->redirect(Yii::$app->request->referrer.$link);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('message', [
            'model' => $form,
        ]);
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
        if (($model == StatementTransfer::class && !$modelOne->count_pages) || ($model == StatementConsentPersonalData::class && !$modelOne->count_pages)) {
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
                $model = $this->create($form, $modelOne);
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
     * @param integer $id
     * @param integer $modelOne
     * @return mixed
     * @throws NotFoundHttpException
     * @var $model BaseActiveRecord;
     */
    protected function model($modelOne, $id): BaseActiveRecord
    {
        if ($modelOne && (($model = $modelOne::findOne(['id' => $id])) !== null)) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }

    /**
     * @param integer $id
     * @param $hash
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionAccepted($id, $hash)
    {
        $modelName = FileHelper::validateModel($hash);
        $model = $this->findModel($id, $modelName);
        try {
            $this->service->accepted($model->id);
            $link = $model ? $model->hashId : "";
            return $this->redirect(Yii::$app->request->referrer.$link);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(Yii::$app->request->referrer);
        }
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
        $form = $this->findModel($id, $model);
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->edit($form);
                $link = $form ? $form->hashId : "";
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

    public function create(File $form, BaseActiveRecord $model)
    {
        if($form->file_name) {
            $this->correctImageFile($form->file_name);
            if (FileHelper::listCountModels()[$model::className()]) {
                $arrayCount = FileHelper::listCountModels()[$model::className()];
            } else {
                $arrayCount = $model->count_pages;
            }
            if(in_array($model::className() ,[PassExamProtocol::class, PassExamStatement::class])) {
                $user = $model->passExam->statement->user_id;
            }else {
                $user = $model->statement->user_id;
            }
            $true = $arrayCount ==  File::find()->andWhere(['user_id' => $user, 'model' => $model::className()
                    , 'record_id' => $model->id])->count();
            if($true) {
                throw new \DomainException('Вы загрузили достаточное количество файлов!');
            }
            $modelFile  = File::create($form->file_name,  $user, $model::className(), $model->id);
            $modelFile->save();
            return $modelFile;
        }
    }

    public function actionSend($userId) {
        try {
            $this->submittedDocumentsService->examSend($userId);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        } catch (\Exception $e) {
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function correctImageFile(UploadedFile $file) {
        $array = ["image/png", 'image/jpeg'];
        $type = IfFile::getMimeType($file->tempName, null, false);
        if (!in_array($type, $array)) {
            throw new \DomainException('Неверный тип файла, разрешено загружать только файлы с расширением jpg или png');
        }
    }

    public function edit(File $form)
    {
        $model = $form;
        if($form->file_name) {
            $this->correctImageFile($form->file_name);
            $model->setFile($form->file_name);
            if($model->isNoAcceptedStatus())
            {
                $model->setStatus(FileHelper::STATUS_WALT);
                $modelOne = $model->model::findOne($model->record_id);
                if(method_exists($modelOne, 'setStatus')) {
                    $modelOne->setStatus(FileHelper::STATUS_WALT);
                    $modelOne->save();
                }
            }
            $model->save();
        }
    }

    /**
     * @param integer $id
     * @param $hash
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionReturn($id, $hash)
    {
        $modelName = FileHelper::validateModel($hash);
        $model = $this->findModel($id, $modelName);
        try {
            $this->service->returnFile($model->id);
            $link = $model ? $model->hashId : "";
            return $this->redirect(Yii::$app->request->referrer.$link);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    /**
     * @param integer $id
     * @param $model
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id, $model): File
    {
        if (($model = File::findOne(['id'=>$id, 'model'=> $model])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }


}