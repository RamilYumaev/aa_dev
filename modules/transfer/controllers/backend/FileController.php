<?php
namespace modules\transfer\controllers\backend;

use modules\dictionary\models\JobEntrant;
use modules\entrant\forms\FileMessageForm;
use modules\entrant\helpers\FileHelper;
use modules\transfer\models\File;
use modules\entrant\searches\FileSearch;
use modules\transfer\services\FileService;
use yii\bootstrap\ActiveForm;;
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