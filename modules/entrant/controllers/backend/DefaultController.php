<?php

namespace modules\entrant\controllers\backend;

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\dictionary\models\JobEntrant;
use modules\entrant\helpers\AisReturnDataHelper;
use modules\entrant\helpers\DataExportHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementConsentCg;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\models\UserAis;
use modules\entrant\readRepositories\ProfileStatementReadRepository;
use modules\entrant\searches\ProfilesStatementSearch;
use olympic\models\auth\Profiles;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class DefaultController extends Controller
{
    /* @return  JobEntrant*/
    protected function getJobEntrant() {
        return Yii::$app->user->identity->jobEntrant();
    }


    public function actionIndex($type = null)
    {
        $searchModel = new ProfilesStatementSearch($this->jobEntrant, $type);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'type' => $type
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
