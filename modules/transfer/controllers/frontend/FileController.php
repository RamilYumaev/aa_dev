<?php
namespace modules\transfer\controllers\frontend;

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\helpers\FileHelper;
use modules\transfer\models\File;
use modules\transfer\models\PassExam;
use modules\transfer\models\ReceiptContractTransfer;
use modules\transfer\models\StatementAgreementContractTransferCg;
use modules\transfer\models\StatementConsentPersonalData;
use modules\transfer\models\StatementTransfer;
use yii\bootstrap\ActiveForm;
use yii\db\BaseActiveRecord;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper as IfFile;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

class FileController extends Controller
{

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
     * @param BaseActiveRecord $modelOne
     * @return mixed
     * @throws NotFoundHttpException
     * @var $model BaseActiveRecord;
     */
    protected function model($modelOne, $id): BaseActiveRecord
    {
        if ($modelOne == StatementAgreementContractTransferCg::class && (($model = $modelOne::find()->alias('sactcg')->joinWith("statementTransfer.passExam")
                ->andWhere(['sactcg.id' => $id])
                ->andWhere(['finance'=> DictCompetitiveGroupHelper::FINANCING_TYPE_CONTRACT])
                ->andWhere(['user_id'=> $this->getUser(),
                    'success_exam'=> PassExam::SUCCESS])->one()) !== null)) {
            return $model;
        }

        if ($modelOne == ReceiptContractTransfer::class && (($model = $modelOne::find()->alias('sactcg')->joinWith("contractCg.statementTransfer.passExam")
                    ->andWhere(['sactcg.id' => $id])
                    ->andWhere(['finance'=> DictCompetitiveGroupHelper::FINANCING_TYPE_CONTRACT])
                    ->andWhere(['user_id'=> $this->getUser(),
                        'success_exam'=> PassExam::SUCCESS])->one()) !== null)) {
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
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id, $hash)
    {
        $modelName = FileHelper::validateModel($hash);
        $model = $this->findModel($id, $modelName);
        $hashId = $model->hashId;
        try {
             $model->delete();
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer . $hashId);
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
            $true = $arrayCount ==  File::find()->andWhere(['user_id' => $this->getUser(), 'model' => $model::className()
                    , 'record_id' => $model->id])->count();
            if($true) {
                throw new \DomainException('Вы загрузили достаточное количество файлов!');
            }
            $modelFile  = File::create($form->file_name, $this->getUser(), $model::className(), $model->id);
            $modelFile->save();

            return $modelFile;
        }
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
}