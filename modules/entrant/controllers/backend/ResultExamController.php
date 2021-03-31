<?php


namespace modules\entrant\controllers\backend;
use dictionary\models\DictCompetitiveGroup;
use kartik\mpdf\Pdf;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\dictionary\models\JobEntrant;
use modules\entrant\forms\StatementIndividualAchievementsMessageForm;
use modules\entrant\forms\StatementMessageForm;
use modules\entrant\helpers\DataExportHelper;
use modules\entrant\helpers\FileCgHelper;
use modules\entrant\helpers\PdfHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Statement;
use modules\entrant\models\UserAis;
use modules\entrant\readRepositories\ResultExamRepository;
use modules\entrant\readRepositories\StatementReadRepository;
use modules\entrant\searches\StatementSearch;
use modules\entrant\services\StatementService;
use modules\exam\helpers\ExamStatementHelper;
use modules\exam\models\ExamAttempt;
use yii\base\ExitException;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;


class ResultExamController extends Controller
{
    private $service;

    public function __construct($id, $module,StatementService $service,  $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    public function beforeAction($event)
    {
        if($this->getJobEntrant()->isStatusDraft() || !in_array($this->jobEntrant->category_id, JobEntrantHelper::listCategoriesZUK()) ) {
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
        $query = new ResultExamRepository($this->getJobEntrant());
        $dataProvider = new ActiveDataProvider(['query' => $query->readData()]);

       return $this->render('index',['dataProvider'=> $dataProvider]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */

    public function actionView($id)
    {
       $model = $this->findModel($id);

        return $this->render('view',['cg' => $model ]);
    }

    /**
     * @param $cg
     * @param $attempt
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */

    public function actionPdf($cg, $attempt)
    {
        $this->findModel($cg);
        $model = $this->findModelAttempt($attempt);
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'image/jpeg');
        $methods =['SetHeader' => ['Распечатано из системы "АИС Абитуриент" || https://fok.sdo.mpgu.org  ' . date("d.m.Y H:i:s")],
            'SetFooter' => ['|{PAGENO} из {nbpg}|']];
        $content = $this->renderPartial('view_pdf', ['attempt' => $model, 'jobEntrant'=> $this->jobEntrant]);
        $pdf = PdfHelper::generate($content, "Результаты экзамена. ".$model->profile->fio.". ".$model->test->exam->discipline->name. ". ". date("Y") ." ". date('Y-m-d H:i:s').".pdf",
            Pdf::FORMAT_A4,  Pdf::ORIENT_PORTRAIT, $methods);
        $render = $pdf->render();
        return $render;
    }

    /**
     * @param $cg
     * @param $attempt
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */

    public function actionViewR($cg, $attempt)
    {
        $this->findModel($cg);
        $model = $this->findModelAttempt($attempt);
        return $this->renderAjax('view_pdf', ['attempt' => $model, 'jobEntrant'=> $this->jobEntrant]);
    }


    /* @return  JobEntrant*/
    protected function getJobEntrant() {
        return Yii::$app->user->identity->jobEntrant();
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): DictCompetitiveGroup
    {
        $query = (new ResultExamRepository($this->jobEntrant))->readData()->andwhere(['cg.id'=>$id]);

        if (($model = $query->one())  !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModelAttempt($id): ExamAttempt
    {
        if (($model = ExamAttempt::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}