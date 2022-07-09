<?php


namespace modules\exam\controllers\admin;


use dictionary\models\DictDiscipline;
use modules\dictionary\models\JobEntrant;
use modules\entrant\helpers\FileCgHelper;
use modules\entrant\helpers\PdfHelper;
use modules\exam\forms\ExamForm;
use modules\exam\forms\ExamQuestionGroupForm;
use modules\exam\forms\question\ExamQuestionForm;
use modules\exam\forms\question\ExamQuestionNestedCreateForm;
use modules\exam\forms\question\ExamQuestionNestedUpdateForm;
use modules\exam\forms\question\ExamTypeQuestionAnswerForm;
use modules\exam\models\Exam;
use modules\exam\models\ExamQuestion;
use modules\exam\models\ExamQuestionGroup;
use modules\exam\searches\admin\ExamQuestionGroupSearch;
use modules\exam\searches\admin\ExamQuestionSearch;
use modules\exam\searches\admin\ExamSearch;
use modules\exam\services\ExamQuestionGroupService;
use modules\exam\services\ExamQuestionService;
use modules\exam\services\ExamService;
use testing\forms\question\TestQuestionClozeForm;
use testing\forms\question\TestQuestionClozeUpdateForm;
use testing\forms\question\TestQuestionTypesForm;
use testing\helpers\TestQuestionHelper;
use yii\base\ExitException;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\bootstrap\ActiveForm;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ExamQuestionController extends Controller
{
    private $service;

    public function __construct($id, $module, ExamQuestionService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ExamQuestionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param integer $discipline_id
     * @return mixed
     * @throws InvalidConfigException
     * @throws \Mpdf\MpdfException
     * @throws \setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException
     * @throws \setasign\Fpdi\PdfParser\PdfParserException
     * @throws \setasign\Fpdi\PdfParser\Type\PdfTypeException
     */

    public function actionPdf($discipline_id)
    {
        ini_set('max_execution_time', '300');
        ini_set("pcre.backtrack_limit", "5000000");
        $questions = ExamQuestion::find()->andWhere(['discipline_id' => $discipline_id])->all();
        $discipline= DictDiscipline::findOne($discipline_id);

        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'image/jpeg');

        $content = $this->renderPartial('pdf/main', ["questions" => $questions]);
        $pdf = PdfHelper::generate($content, $discipline->name.'.pdf');
        $render = $pdf->render();
        return $render;
    }
}