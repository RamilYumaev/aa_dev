<?php

namespace backend\controllers\dictionary;


use dictionary\forms\DictSchoolsCreateForm;
use dictionary\forms\DictSchoolsEditForm;
use dictionary\forms\search\DictSchoolsSearch;
use dictionary\models\DictSchools;
use dictionary\models\DictSchoolsReport;
use dictionary\services\DictSchoolsReportService;
use dictionary\services\DictSchoolsService;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class DictSchoolsReportController extends Controller
{
    private $service;

    public function __construct($id, $module, DictSchoolsReportService $service, $config = [])
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
                ],
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
       // $searchModel = new DictSchoolsSearch();
        $dataProvider =  new ActiveDataProvider(['query'=> DictSchoolsReport::find()]);
        // $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
          //  'searchModel' => $searchModel,
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
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'school' => $this->findModel($id),
        ]);
    }

    /**
     * @param $id
     * @param $school_id
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionSelectSchool($school_id, $id)
    {
        $model = $this->findModel($id);
        try {
            $this->service->add($model->id,$school_id);
            $msg = "Добавлен!";
        } catch (\DomainException $e) {
            $msg = $e->getMessage();
        }
        echo $msg;

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
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): DictSchoolsReport
    {
        if (($model = DictSchoolsReport::findOne($id)) !== null) {
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
