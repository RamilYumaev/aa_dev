<?php
namespace modules\dictionary\controllers;
use modules\dictionary\forms\ReworkingVolunteeringForm;
use modules\dictionary\models\JobEntrant;
use modules\dictionary\models\ScheduleVolunteering;
use modules\dictionary\searches\ScheduleVolunteeringSearch;
use modules\dictionary\services\ScheduleVolunteeringService;
use Yii;
use yii\base\Model;
use yii\db\BaseActiveRecord;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ScheduleVolunteeringController extends Controller
{
    private $service;
    private $model;
    public function __construct($id, $module,
                                ScheduleVolunteeringService $service,
                                $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;

    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['call-center'],
                    ]
                ],
            ],
        ];
    }

    /* @return  JobEntrant*/
    protected function getJobEntrant() {
        return Yii::$app->user->identity->jobEntrant();
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */

    public function actionReworking($id)
    {
        /**
         * @var ScheduleVolunteering $model
         */
        $model =  $this->findModel($id);
        $form =  new ReworkingVolunteeringForm($model->reworkingVolunteering);
        $form->setScenario(ReworkingVolunteeringForm::FIRST);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try{
                $this->service->addAddRework($id, $form);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('add', ['model'=> $form]);
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        /**
         * @var $searchModel Model
         */
        $searchModel = new ScheduleVolunteeringSearch($this->jobEntrant);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return BaseActiveRecord
     * @throws NotFoundHttpException
     */
    protected function findModel($id): ?ScheduleVolunteering
    {
        if (($model = ScheduleVolunteering::findOne(['id'=>$id, 'job_entrant_id'=> $this->jobEntrant->id ])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }
}