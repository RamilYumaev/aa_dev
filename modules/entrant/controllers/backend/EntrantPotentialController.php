<?php

namespace modules\entrant\controllers\backend;

use modules\dictionary\models\JobEntrant;
use modules\entrant\helpers\AisReturnDataHelper;
use modules\entrant\helpers\DataExportHelper;
use modules\entrant\readRepositories\ProfileStatementReadRepository;
use modules\entrant\searches\ProfilesPotentialSearch;
use modules\entrant\searches\ProfilesStatementSearch;
use modules\entrant\services\EmailDeliverService;
use olympic\models\auth\Profiles;
use Yii;
use yii\base\ExitException;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class EntrantPotentialController extends Controller
{
    private $service;
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'send-error' => ['POST'],
                ],
            ],
        ];
    }

    /* @return  JobEntrant*/
    protected function getJobEntrant() {
        return Yii::$app->user->identity->jobEntrant();
    }

    public function beforeAction($event)
    {
        if(!$this->jobEntrant->right_full) {
            Yii::$app->session->setFlash("warning", 'Страница недоступна');
            Yii::$app->getResponse()->redirect(['site/index']);
            try {
                Yii::$app->end();
            } catch (ExitException $e) {
            }
        }
        return true;
    }

    /**
     * @param  $is_id
     * @return mixed
     */
    public function actionIndex($is_id = null)
    {
        $searchModel = new ProfilesPotentialSearch($this->jobEntrant, $is_id);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * @param integer $user
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionFull($user)
    {
        $profile = $this->findModel($user);
        return $this->render('full', [
            'profile' => $profile
        ]);
    }

    /**
     * @param integer $user
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionFiles($user)
    {
        $profile = $this->findModel($user);
        return $this->render('files', [
            'profile' => $profile
        ]);
    }

    public function actionExcel()
    {
        \moonland\phpexcel\Excel::widget([
            'asAttachment'=>true,
            'fileName' => date('d-m-Y H-i-s').' file',
            'models' => (new ProfileStatementReadRepository($this->jobEntrant))->readData(AisReturnDataHelper::AIS_NO)->all(),
            'mode' => 'export', //default value as 'export'
            'columns' => ['user_id'], //without header working, because the header will be get label from attribute label.
            'headers' => ['user_id'=> "Юзер ID"],
        ]);
    }

    /**
     * @param integer $user
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionDataJson($user) {
        $profile = $this->findModel($user);
        $result = DataExportHelper::dataIncoming($profile->user_id);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $result;
    }

    /**
     * @param integer $user_id
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionPreemptiveRight($user_id)
    {
        $profile = $this->findModel($user_id);
        return $this->render('preemptive-right', [
            'profile' => $profile
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): Profiles
    {
        $query = (new ProfileStatementReadRepository($this->jobEntrant))->readData(null)
            ->andWhere(['profiles.user_id' => $id]);

        if (($model = $query->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Такой страницы не существует.');
    }


}
