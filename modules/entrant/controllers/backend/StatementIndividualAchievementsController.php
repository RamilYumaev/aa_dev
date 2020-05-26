<?php


namespace modules\entrant\controllers\backend;
use modules\entrant\helpers\FileCgHelper;
use modules\entrant\helpers\PdfHelper;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\searches\StatementIASearch;
use modules\entrant\services\StatementIndividualAchievementsService;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;


class StatementIndividualAchievementsController extends Controller
{
    private $service;

    public function __construct($id, $module, StatementIndividualAchievementsService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }


    public function actionIndex()
    {
        $searchModel = new StatementIASearch();
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
        $this->render('view', ['statement' => $statement]);
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
        if (($model = StatementIndividualAchievements::findOne(['id'=>$id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }



}