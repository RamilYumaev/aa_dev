<?php


namespace modules\dictionary\controllers;

use common\auth\models\User;
use modules\dictionary\forms\TestingEntrantForm;
use modules\dictionary\models\TestingEntrant;
use modules\dictionary\models\TestingEntrantDict;
use modules\dictionary\searches\TestingEntrantSearch;
use modules\dictionary\services\TestingEntrantService;
use modules\entrant\forms\AgreementMessageForm;
use modules\dictionary\forms\TestingEntrantDictForm;
use modules\usecase\ControllerClass;
use Monolog\Handler\IFTTTHandler;
use Yii;
use yii\base\Exception;
use yii\bootstrap\ActiveForm;
use yii\filters\AccessControl;
use yii\helpers\FileHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

class TestingEntrantController extends ControllerClass
{

    public function __construct($id, $module,
                                TestingEntrantService $service,
                                TestingEntrant $model,
                                TestingEntrantForm $formModel,
                                TestingEntrantSearch $searchModel,
                                $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->model = $model;
        $this->formModel = $formModel;
        $this->searchModel = $searchModel;
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create', 'index', 'update', 'image-delete','delete','status','add-task','message','status-task','view'],
                        'roles' => ['dev']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['message', 'index','status-task','view', 'image-delete'],
                        'roles' => ['@']
                    ]
                ],
            ],
        ];
    }

    /**
     * @param $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        if(!\Yii::$app->user->can('dev') && $model->user_id != \Yii::$app->user->identity->getId()) {
            throw new NotFoundHttpException('Такой страницы не существует.');
        }
        return $this->render('view',['testing' => $model]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionMessage($dict, $id)
    {
        $model = TestingEntrantDict::findOne(['id_dict_testing_entrant' => $dict,
            'id_testing_entrant' => $id]);
        if(!$model) {
            throw new NotFoundHttpException('Такой страницы не существует.');
        }
        $form = new TestingEntrantDictForm($model);
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $form->images = UploadedFile::getInstances($form, 'images');
                $model->setErrorNote($form->message);
                $alias = \Yii::getAlias('@entrant');
                $path ='/web/uploads';
                if(!FileHelper::createDirectory($alias . $path)) {
                    throw  new \DomainException("Не удалось создать папку ". $alias . $path);
                }
                foreach ($form->images as $key => $file) {
                    $number = $model->count_files + ($key+1);
                    $file->saveAs($alias.$path.'/' . $model->getNameFile($number). '.' . $file->extension);
                }
                $count = $model->count_files+count($form->images);
                $model->setCountFiles($count);
                $model->setStatus(TestingEntrantDict::STATUS_ERROR);
                $model->save(false);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            } catch (Exception $e) {
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('message', [
            'model' => $form,
        ]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionAddTask( $id)
    {
        $model = $this->findModel($id);
        $form = new TestingEntrantForm($model);
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->saveRelation($form, $model->id);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('add-task', [
            'model' => $form,
        ]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionStatusTask($dict, $id, $status)
    {
        $model = TestingEntrantDict::findOne(['id_dict_testing_entrant' => $dict,
            'id_testing_entrant' => $id]);
        if(!$model) {
            throw new NotFoundHttpException('Такой страницы не существует.');
        }
        try {
            $model->setStatus($status);
            $model->save(false);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionImageDelete($dict, $id, $key)
    {
        $model = TestingEntrantDict::findOne(['id_dict_testing_entrant' => $dict,
            'id_testing_entrant' => $id]);
        if(!$model) {
            throw new NotFoundHttpException('Такой страницы не существует.');
        }
        try {
            $alias = \Yii::getAlias('@entrant');
            $path ='/web/uploads';
            $path = $alias.$path.'/' . $model->getNameFile($key). '.' . 'jpg';
            if(!is_file($path)) {
                throw  new \DomainException('Такого файла не существует');
            }
            unlink($path);
            $model->setCountFiles($model->count_files-1);
            $model->save(false);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @param integer $id
     * @param $status
     * @return mixed
     */
    public function actionStatus($id, $status)
    {
        try {
            $this->service->status($id,$status);
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'id'=> $id]);
    }
}