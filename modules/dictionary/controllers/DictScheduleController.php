<?php
namespace modules\dictionary\controllers;
use modules\dictionary\models\JobEntrant;
use modules\dictionary\searches\DictScheduleSearch;
use modules\dictionary\services\DictScheduleService;
use modules\dictionary\forms\DictScheduleForm;
use modules\dictionary\models\DictSchedule;
use modules\usecase\ControllerClass;
use Yii;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class DictScheduleController extends ControllerClass
{
    public function __construct($id, $module,
                                DictScheduleService $service,
                                DictScheduleForm $formModel,
                                DictSchedule $model,
                                DictScheduleSearch $searchModel,
                                $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->model = $model;
        $this->formModel = $formModel;
        $this->service = $service;
        $this->searchModel = $searchModel;
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
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['dev']
                    ]
                ],
            ],
        ];
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionSelectSchedule($id) {
        $this->findModel($id);
        try {
            $this->service->addSchedule($id, $this->jobEntrant->id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /* @return  JobEntrant*/
    protected function getJobEntrant() {
        return Yii::$app->user->identity->jobEntrant();
    }

    /**
     * @return mixed
     */
    public function actionSelectIndex()
    {
        /**
         * @var $searchModel Model
         */
        $searchModel = new $this->searchModel;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('select-index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'jobEntrant' => $this->jobEntrant
        ]);
    }
}