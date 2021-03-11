<?php


namespace modules\entrant\controllers\backend;


use modules\dictionary\forms\JobEntrantAndProfileForm;
use modules\dictionary\forms\VolunteeringForm;
use modules\dictionary\models\JobEntrant;
use modules\dictionary\models\Volunteering;
use modules\dictionary\services\VolunteeringService;
use modules\entrant\services\AgreementService;
use yii\base\ExitException;
use yii\web\Controller;
use Yii;

class VolunteeringController extends Controller
{
    private $service;

    public function __construct($id, $module, VolunteeringService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function beforeAction($event)
    {
        if(!$this->getJobEntrant()) {
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
        if (Yii::$app->user->isGuest) {
            return $this->controller->goHome();
        }
        $model = Volunteering::findOne(['job_entrant_id' => $this->jobEntrant->id]) ?? null;

        $form = new VolunteeringForm($model);
        $form->job_entrant_id = $this->jobEntrant->id;
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->createOne($form, $model);
                return $this->goHome();
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('index', [
            'model' => $form,
            'volunteering' => $model
        ]);
    }

    /* @return  JobEntrant*/
    protected function getJobEntrant() {
        return Yii::$app->user->identity->jobEntrant();
    }
}