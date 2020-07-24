<?php


namespace modules\exam\controllers\frontend;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictDiscipline;
use modules\entrant\models\AdditionalInformation;
use modules\entrant\services\AdditionalInformationService;
use modules\exam\behaviors\ExamRedirectBehavior;
use modules\exam\helpers\ExamCgUserHelper;
use Yii;
use yii\web\Controller;

class DefaultController extends Controller
{
    private $service;

    public function __construct($id, $module, AdditionalInformationService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;

    }


    public function behaviors()
    {
        return [
            ExamRedirectBehavior::class,
        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $model = $this->findModel();
        if($model && !$model->exam_check) {
            return $this->redirect(['consent']);
        }
            return $this->render('index', [
                'examList' => ExamCgUserHelper::examList($this->getUserId())]);

    }

    /**
     * @return mixed
     */
    public function actionConsent()
    {
        $model = $this->findModel();
        if($model && $model->exam_check) {
            return $this->redirect(['index']);
        }
        if (Yii::$app->request->post()) {
            $exam = Yii::$app->request->post('exam');
            if(!$exam) {
                Yii::$app->session->setFlash("warning", 'Вы не поставили птичку');
                return $this->redirect(Yii::$app->request->referrer);
            } else {
                try {
                    $this->service->examCheck($model);
                    return $this->redirect(['index']);
                } catch (\DomainException $e) {
                    Yii::$app->errorHandler->logException($e);
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }
        }
        return $this->render('consent');
    }

    protected function findModel(): ?AdditionalInformation
    {
        return AdditionalInformation::findOne([ 'user_id' => $this->getUserId() ]);
    }

    private function getUserId()
    {
        return  Yii::$app->user->identity->getId();
    }
}