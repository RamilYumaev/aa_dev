<?php
namespace modules\entrant\controllers\backend;

use modules\entrant\forms\FileForm;
use modules\entrant\forms\FileMessageForm;
use modules\entrant\helpers\FileHelper;
use modules\entrant\models\File;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementConsentCg;
use modules\entrant\models\StatementConsentPersonalData;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\services\FileService;
use yii\bootstrap\ActiveForm;
use yii\db\BaseActiveRecord;
use yii\filters\VerbFilter;
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
//
//    public function behaviors(): array
//    {
//        return [
//            'verbs' => [
//                'class' => VerbFilter::class,
//                'actions' => [
//                    'accepted' => ['POST'],
//                ],
//            ],
//        ];
//    }

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

    public function actionMessage($hash, $id)
    {
        $model = FileHelper::validateModel($hash);
        $file = $this->findModel($id, $model);
        $form = new FileMessageForm($file);
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->addMessage($file->id, $form);
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
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
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