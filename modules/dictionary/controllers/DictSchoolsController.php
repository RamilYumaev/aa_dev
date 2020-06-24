<?php

namespace modules\dictionary\controllers;


use dictionary\forms\DictSchoolsCreateForm;
use dictionary\forms\DictSchoolsEditForm;
use dictionary\forms\search\DictSchoolsSearch;
use dictionary\models\DictSchools;
use dictionary\services\DictSchoolsService;
use yii\web\Controller;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class DictSchoolsController extends Controller
{
    private $service;

    public function __construct($id, $module, DictSchoolsService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'select-school' => ['POST'],
                    'add-in-report' => ['POST'],
                    'reset-report' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DictSchoolsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new DictSchoolsCreateForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->create($form);
                return $this->redirect(['index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $form = new DictSchoolsEditForm($model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($model->id, $form);
                return $this->redirect(['index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'school' => $model,
        ]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionAddInReport($id)
    {
        $model = $this->findModel($id);
        try {
            $this->service->addSchoolReport($model->id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    /**
     * @param $id
     * @param $school_id
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionResetReport($id, $school_id)
    {
        $model = $this->findModel($id);
        try {
            $this->service->resetReport($model->id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['dictionary/dict-schools-report/view', 'id' => $school_id]);
    }



    /**
     * @param $id
     * @param $school_id
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionSelectSchool($id, $school_id)
    {
        $model = $this->findModel($id);
        try {
            $this->service->addDictSchoolReportId($model->id, $school_id);
            $msg = "Добавлен!";
        } catch (\DomainException $e) {
            $msg = $e->getMessage();
        }
        Yii::$app->response->format = Response::FORMAT_RAW;
        return  $msg;

    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): DictSchools
    {
        if (($model = DictSchools::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $this->service->remove($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }


}
