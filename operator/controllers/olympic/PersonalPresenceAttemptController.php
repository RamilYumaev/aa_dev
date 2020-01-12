<?php
namespace operator\controllers\olympic;

use olympic\helpers\PersonalPresenceAttemptHelper;
use olympic\models\PersonalPresenceAttempt;
use olympic\repositories\OlimpicListRepository;
use olympic\services\PersonalPresenceAttemptService;
use testing\forms\AddFinalMarkTableForm;
use yii\base\Model;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;

class PersonalPresenceAttemptController extends Controller
{
    private $service;
    private $olimpicListRepository;

    public function __construct($id, $module, PersonalPresenceAttemptService $service,
                                OlimpicListRepository $olimpicListRepository, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->olimpicListRepository = $olimpicListRepository;
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
     * @param integer $olympic_id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\web\HttpException
     */
    public function actionIndex($olympic_id)
    {
        return $this->renderList($olympic_id);
    }

    /**
     * @param $olympic_id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\web\HttpException
     */
    public function actionAddFinalMark($olympic_id)
    {
        $olympic = $this->isPersonalAttempt($olympic_id);
        try {
            $this->isFinishOlympic($olympic->id);
            $model = PersonalPresenceAttempt::find()->userPresence($olympic)->indexBy('id')->all();
            if ($model) {
                $forms = new AddFinalMarkTableForm($model);
                if (Model::loadMultiple($forms->arrayMark, Yii::$app->request->post())) {
                    try {
                        $this->service->createMark($forms);
                        return $this->redirect(['index', 'olympic_id' => $olympic->id]);
                    } catch (\DomainException $e) {
                        Yii::$app->errorHandler->logException($e);
                        Yii::$app->session->setFlash('error', $e->getMessage());
                    }
                }
                return $this->render('@backend/views/olympic/personal-presence-attempt/add-final-mark',
                    ['models' => $forms, 'olympic' => $olympic]);
            }
            else {
                Yii::$app->session->setFlash('error', 'Вы не можете добавить оценки, так как нет ни одного присутствующего на очном туре');
                return  $this->redirect(['index', 'olympic_id' => $olympic->id]);
            }
        }catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return  $this->redirect(['index', 'olympic_id' => $olympic->olimpic_id]);
    }

    /**
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\web\HttpException
     */
    public function actionCreate($olympic_id)
    {
        $olympic = $this->findOlympic($olympic_id);
        try {
            $o = $this->service->create($olympic->id);
            return $this->redirect(['index', 'olympic_id' => $o->id]);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['olympic/olympic/view', 'id' => $olympic->olimpic_id]);
    }

    /**
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\web\HttpException
     */
    public function actionFinish($olympic_id, $status)
    {
        $olympic = $this->isPersonalAttempt($olympic_id);
        try {
            $olympic = $this->isFinishOlympic($olympic->id);
            try {
                $this->service->finish($olympic->id, $status);
                return $this->redirect(['index', 'olympic_id' => $olympic->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return  $this->redirect(['index', 'olympic_id' => $olympic->id]);
    }

    /**
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\web\HttpException
     */
    public function actionAppeal($olympic_id)
    {
        $olympic = $this->isPersonalAttempt($olympic_id);
        try {
            $this->service->appeal($olympic->id);
            return $this->redirect(['index', 'olympic_id' => $olympic->id]);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }


    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\web\HttpException
     */
    public function actionDeleteFinalMark($id)
    {
        $model = $this->findModel($id);
        try {
            $olympic = $this->isFinishOlympic($model->olimpic_id);
            $this->service->deleteMark($model->id);
            if (Yii::$app->request->isAjax) {
                return $this->renderList($olympic->id);
            }
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index', 'olympic_id' =>  $model->olimpic_id]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\web\HttpException
     */
    public function actionPresenceStatus($id)
    {
        $model = $this->findModel($id);
        try {
            $olympic = $this->isFinishOlympic($model->olimpic_id);
            $this->service->presenceStatus($model->id, PersonalPresenceAttemptHelper::PRESENCE);
            if (Yii::$app->request->isAjax) {
                return $this->renderList($olympic->id);
                //return $this->renderList($model->olimpic_id);
            }
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index', 'olympic_id' =>  $model->olimpic_id]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\web\HttpException
     */
    public function actionNoPresenceStatus($id)
    {
        $model = $this->findModel($id);
        try {
            $olympic = $this->isFinishOlympic($model->olimpic_id);
            $this->service->presenceStatus($model->id, PersonalPresenceAttemptHelper::NON_APPEARANCE);
            if (Yii::$app->request->isAjax) {
                return $this->renderList($olympic->id);
                //return $this->renderList($model->olimpic_id);
            }
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index', 'olympic_id' =>  $model->olimpic_id]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\web\HttpException
     */
    public function actionNullPresenceStatus($id)
    {
        $model = $this->findModel($id);
        try {
            $olympic = $this->isFinishOlympic($model->olimpic_id);
            $this->service->presenceStatus($model->id, null);
            if (Yii::$app->request->isAjax) {
                return $this->renderList($olympic->id);
            }
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index', 'olympic_id' =>  $model->olimpic_id]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\web\HttpException
     */
    public function actionFirstPlace($id)
    {
        $model = $this->findModel($id);
        try {
            $olympic = $this->isFinishOlympic($model->olimpic_id);
            $this->service->rewardStatus($model->id, PersonalPresenceAttemptHelper::FIRST_PLACE);
            if (Yii::$app->request->isAjax) {
                return $this->renderList($olympic->id);
            }
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index', 'olympic_id' =>  $model->olimpic_id]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\web\HttpException
     */
    public function actionSecondPlace($id)
    {
        $model = $this->findModel($id);
        try {
            $olympic = $this->isFinishOlympic($model->olimpic_id);
            $this->service->rewardStatus($model->id, PersonalPresenceAttemptHelper::SECOND_PLACE);
            if (Yii::$app->request->isAjax) {
                return $this->renderList($olympic->id);
            }
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index', 'olympic_id' =>  $model->olimpic_id]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\web\HttpException
     */
    public function actionThirdPlace($id)
    {
        $model = $this->findModel($id);
        try {
            $olympic = $this->isFinishOlympic($model->olimpic_id);
            $this->service->rewardStatus($model->id, PersonalPresenceAttemptHelper::THIRD_PLACE);
            if (Yii::$app->request->isAjax) {
                return $this->renderList($olympic->id);
            }
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index', 'olympic_id' =>  $model->olimpic_id]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\web\HttpException
     */
    public function actionRemovePlace($id)
    {
        $model = $this->findModel($id);
        try {
            $olympic = $this->isFinishOlympic($model->olimpic_id);
            $this->service->removeAllStatuses($model->id);
            if (Yii::$app->request->isAjax) {
                return $this->renderList($olympic->id);
            }
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index', 'olympic_id' =>  $model->olimpic_id]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\web\HttpException
     */
    public function actionNomination($id, $nominationId)
    {
        $model = $this->findModel($id);
        try {
            $olympic = $this->isFinishOlympic($model->olimpic_id);
            $this->service->nomination($model->id, $nominationId);
            if (Yii::$app->request->isAjax) {
                return $this->renderList($olympic->id);
            }
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index', 'olympic_id' =>  $model->olimpic_id]);
    }

    /**
     * @param integer $olympic_id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\web\HttpException
     */

    protected function renderList($olympic_id)
    {
        $olympic= $this->isPersonalAttempt($olympic_id);
        $method = Yii::$app->request->isAjax ? 'renderAjax' : 'render';
        return $this->$method('@backend/views/olympic/personal-presence-attempt/index', ['olympic' => $olympic]);
    }

    /**
     * @param integer $olympic_id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\web\HttpException
     */

    protected function isPersonalAttempt($olympic_id) {
        $olympic = $this->findOlympic($olympic_id);

        if(!PersonalPresenceAttemptHelper::isPersonalAttemptOlympic($olympic->id))  {
            throw new NotFoundHttpException('Нет такой страницы');
        }

        return $olympic;
    }

    /**
     * @param $olympic_id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\web\HttpException
     */

    protected function findOlympic($olympic_id) {

        return $this->olimpicListRepository->getManager($olympic_id);
    }

    /**
     * @param $olympic_id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\web\HttpException
     */

    protected function isFinishOlympic($olympic_id) {
        $olympic = $this->olimpicListRepository->getManager($olympic_id);
        if ($olympic->isResultEndTour()) {
            throw new \DomainException('Данная олимпиада завершена');
        }
        return $olympic;
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): PersonalPresenceAttempt
    {
        if (($model = PersonalPresenceAttempt::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }


}
