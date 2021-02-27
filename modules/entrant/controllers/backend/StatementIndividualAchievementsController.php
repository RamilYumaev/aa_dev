<?php


namespace modules\entrant\controllers\backend;
use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\dictionary\models\JobEntrant;
use modules\entrant\forms\AgreementMessageForm;
use modules\entrant\forms\StatementIAMessageForm;
use modules\entrant\forms\StatementIndividualAchievementsMessageForm;
use modules\entrant\helpers\FileCgHelper;
use modules\entrant\helpers\PdfHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Anketa;
use modules\entrant\models\StatementIa;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\models\UserAis;
use modules\entrant\readRepositories\StatementIAReadRepository;
use modules\entrant\searches\StatementIASearch;
use modules\entrant\services\StatementIndividualAchievementsService;
use yii\base\ExitException;
use yii\bootstrap\ActiveForm;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;


class StatementIndividualAchievementsController extends Controller
{
    private $service;

    public function __construct($id, $module,
                                StatementIndividualAchievementsService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /* @return  JobEntrant*/
    protected function getJobEntrant() {
        return Yii::$app->user->identity->jobEntrant();
    }


    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'status-accepted' => ['POST'],
                    'delete-ia' => ['POST'],
                ],
            ],
        ];
    }



    public function beforeAction($event)
    {
        if($this->getJobEntrant()->isStatusDraft() || !in_array($this->jobEntrant->category_id, JobEntrantHelper::listCategoriesZID())) {
            Yii::$app->session->setFlash("warning", 'Страница недоступна');
            Yii::$app->getResponse()->redirect(['site/index']);
            try {
                Yii::$app->end();
            } catch (ExitException $e) {
            }
        }
        return true;
    }


    public function actionIndex($status = null)
    {
        $searchModel = new StatementIASearch($this->jobEntrant, $status);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     *
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionView($id)
    {
        $statement = $this->findModel($id);
        if($statement->isStatusWalt()) {
            try {
                $this->service->addStatusStatement($id, StatementHelper::STATUS_VIEW);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('view', ['statement' => $statement]);
    }

    /**
     *
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */

    public function actionPdf($id)
    {
        $statementIA = $this->findModel($id);
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'image/jpeg');

        $content = $this->renderPartial('@modules/entrant/views/frontend/statement-individual-achievements/pdf/_main', ["statementIA" => $statementIA ]);
        $pdf = PdfHelper::generate($content, FileCgHelper::fileNameIA($statementIA, '.pdf'));
        return $pdf->render();
    }

    /**
     *
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */


    public function actionStatusAccepted($id)
    {
        $this->findModel($id);
        try {
            $this->service->addStatusStatement($id, StatementHelper::STATUS_ACCEPTED);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     *
     * @param $id
     * @param $status
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */


    public function actionStatus($id, $status)
    {
        $this->findModelIa($id);
        try {
            $this->service->addStatus($id, $status);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     *
     * @param $id
     * @param $status
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */


    public function actionStatusIndex($id, $status)
    {
        $this->findModel($id);
        try {
            $this->service->addStatusIndex($id, $status);
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

    public function actionMessage($id)
    {
        $model = $this->findModel($id);
        $form = new StatementIndividualAchievementsMessageForm($model);
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->addMessage($model->id, $form);
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
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */


    public function actionDeleteIa($id)
    {
        $model = $this->findModelIa($id);
        $statement = $model->statementIndividualAchievement;
        $bool = $statement->getStatementIa()->count() == 1;
        try {
            $this->service->removeIa($model->id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        if ($bool) {
            return $this->redirect(['index']);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }


    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */


    public function actionMessageIa($id)
    {
        $model = $this->findModelIa($id);
        $form = new StatementIAMessageForm($model);
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->addMessageIa($model->id, $form);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('message-ia', [
            'model' => $form,
        ]);
    }




    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): StatementIndividualAchievements
    {
        $query = (new StatementIAReadRepository($this->jobEntrant))->readData()
            ->andWhere(['statement_individual_achievements.id'=>$id]);

        if (($model = $query->one()) !== null) {
            return $model;
        }


        throw new NotFoundHttpException('Такой страницы не существует.');
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModelIa($id): StatementIa
    {

        if (($model = StatementIa::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }




}