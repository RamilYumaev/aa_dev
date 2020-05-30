<?php

namespace modules\entrant\controllers\backend;

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\dictionary\models\JobEntrant;
use modules\entrant\helpers\DataExportHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementConsentCg;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\models\UserAis;
use modules\entrant\searches\ProfilesStatementSearch;
use olympic\models\auth\Profiles;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class DefaultController extends Controller
{

    /* @var  $jobEntrant JobEntrant*/
    private $jobEntrant;

    public function __construct($id, $module, $config = [])
    {
        $this->jobEntrant = Yii::$app->user->identity->jobEntrant();

        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        $searchModel = new ProfilesStatementSearch($this->jobEntrant);
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
        $query = Profiles::find()
            ->alias('profiles')
            ->innerJoin(Statement::tableName(), 'statement.user_id=profiles.user_id')
            ->andWhere(['>','statement.status', StatementHelper::STATUS_DRAFT])
            ->andWhere(['profiles.user_id' => $id]);

        if(!$this->jobEntrant->isCategoryCOZ()) {
            $query->innerJoin(UserAis::tableName(), 'user_ais.user_id=profiles.user_id');
        }

        if($this->jobEntrant->isCategoryMPGU()) {
            $query->innerJoin(StatementIndividualAchievements::tableName(), 'statement_individual_achievements.user_id=profiles.user_id');
            $query->andWhere(['statement_individual_achievements.edu_level' =>[DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR,
                DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER]]);
        }

        if($this->jobEntrant->isCategoryFOK()) {
            $query->andWhere(['statement.faculty_id' => $this->jobEntrant->faculty_id,
                'statement.edu_level' =>[DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR,
                    DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER]]);
        }

        if($this->jobEntrant->isCategoryTarget()) {
            $query->andWhere([
                'statement.special_right' => DictCompetitiveGroupHelper::TARGET_PLACE]);
        }

        if($this->jobEntrant->isCategoryGraduate()) {
            $query->andWhere([
                'statement.edu_level' => DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL]);
        }

        if(in_array($this->jobEntrant->category_id,JobEntrantHelper::listCategoriesFilial())) {
            $query->andWhere(['statement.faculty_id' => $this->jobEntrant->category_id]);
        }

        if (($model = $query->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Такой страницы не существует.');
    }


}
