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
                    'add-school-index' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider =  new ActiveDataProvider(['query'=> DictSchoolsReport::find()]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
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
            'isAdd' => false
        ]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionAdd($id)
    {
        return $this->render('view', [
            'school' => $this->findModel($id),
            'isAdd' => true
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

    /**
     * @param integer $id
     * @param integer $school_id
     * @return mixed
     */
    public function actionAddSchoolIndex($id, $school_id)
    {
        try {
            $this->service->addIndex($id, $school_id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view','id'=> $id]);
    }



}
