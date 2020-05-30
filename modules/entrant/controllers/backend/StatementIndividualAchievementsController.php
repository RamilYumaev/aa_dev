<?php


namespace modules\entrant\controllers\backend;
use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\dictionary\models\JobEntrant;
use modules\entrant\helpers\FileCgHelper;
use modules\entrant\helpers\PdfHelper;
use modules\entrant\models\Anketa;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\models\UserAis;
use modules\entrant\searches\StatementIASearch;
use modules\entrant\services\StatementIndividualAchievementsService;
use yii\base\ExitException;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;


class StatementIndividualAchievementsController extends Controller
{
    private $service;
    /* @var  $jobEntrant JobEntrant*/
    private $jobEntrant;

    public function __construct($id, $module, StatementIndividualAchievementsService $service, $config = [])
    {
        $this->jobEntrant = Yii::$app->user->identity->jobEntrant();
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function beforeAction($event)
    {
        if(!in_array($this->jobEntrant->category_id, JobEntrantHelper::listCategoriesZID())) {
            Yii::$app->session->setFlash("warning", 'Страница недоступна');
            Yii::$app->getResponse()->redirect(['site/index']);
            try {
                Yii::$app->end();
            } catch (ExitException $e) {
            }
        }
        return true;
    }


    public function actionIndex()
    {
        $searchModel = new StatementIASearch($this->jobEntrant);
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
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): StatementIndividualAchievements
    {
        $query = StatementIndividualAchievements::find()->where(['id'=>$id]);
        $query->innerJoin(UserAis::tableName(), 'user_ais.user_id=statement_individual_achievements.user_id');

        if($this->jobEntrant->isCategoryMPGU()) {
            $query->andWhere(['statement_individual_achievements.edu_level' =>[DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR,
                DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER]]);
        }

        if($this->jobEntrant->isCategoryGraduate()) {
            $query->andWhere([
                'statement_individual_achievements.edu_level' => DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL]);
        }

        if(in_array($this->jobEntrant->category_id,JobEntrantHelper::listCategoriesFilial())) {
            $query->innerJoin(Anketa::tableName(), 'anketa.user_id=statement_individual_achievements.user.user_id');
            $query->andWhere(['anketa.university_choice'=> $this->jobEntrant->category_id]);
        }

        if (($model = $query->one()) !== null) {
            return $model;
        }


        throw new NotFoundHttpException('Такой страницы не существует.');
    }



}