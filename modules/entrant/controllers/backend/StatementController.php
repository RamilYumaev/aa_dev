<?php


namespace modules\entrant\controllers\backend;
use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\dictionary\models\JobEntrant;
use modules\entrant\helpers\FileCgHelper;
use modules\entrant\helpers\PdfHelper;
use modules\entrant\models\Statement;
use modules\entrant\models\UserAis;
use modules\entrant\readRepositories\StatementReadRepository;
use modules\entrant\searches\StatementSearch;
use modules\entrant\services\StatementService;
use yii\base\ExitException;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;


class StatementController extends Controller
{
    private $service;

    public function __construct($id, $module,StatementService $service,  $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    public function beforeAction($event)
    {
        if(!in_array($this->jobEntrant->category_id, JobEntrantHelper::listCategoriesZUK())) {
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
        $searchModel = new StatementSearch($this->jobEntrant, $status);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'status' => $status
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
        $statement = $this->findModel($id);
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'image/jpeg');

        $content = $this->renderPartial('@modules/entrant/views/frontend/statement/pdf/_main', ["statement" => $statement ]);
        $pdf = PdfHelper::generate($content, FileCgHelper::fileName($statement, '.pdf'));
        return $pdf->render();
    }


    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): Statement
    {
        $query = (new StatementReadRepository($this->jobEntrant))->readData()-> andwhere(['statement.id'=>$id]);

        if (($model = $query->one())  !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }

    /* @return  JobEntrant*/
    protected function getJobEntrant() {
        return Yii::$app->user->identity->jobEntrant();
    }


}