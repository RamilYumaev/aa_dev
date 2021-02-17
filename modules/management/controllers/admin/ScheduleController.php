<?php
namespace modules\management\controllers\admin;

use modules\entrant\helpers\PdfHelper;
use modules\management\forms\ScheduleForm;
use modules\management\models\Schedule;
use modules\management\searches\ScheduleSearch;
use modules\management\services\ScheduleService;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class ScheduleController extends Controller
{
    private $service;

    public function __construct($id, $module, ScheduleService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ScheduleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     */

    public function actionPdf()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Schedule::find(),
        ]);

        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'image/jpeg');

        $content = $this->renderPartial('index', [
            'dataProvider' => $dataProvider]);
        $pdf = PdfHelper::generate($content, "График_работы.pdf");
        $render = $pdf->render();
        return $render;

    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Throwable
     */
    public function actionBlocked($id, $is)
    {
        $model = $this->findModel($id);
        try{
            $this->service->blocked($model->id, $is);
        }catch (\Exception $e) {
            Yii::$app->session->setFlash('danger', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): Schedule
    {
        if (($model = Schedule::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }
}