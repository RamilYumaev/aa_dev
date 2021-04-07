<?php
namespace modules\management\controllers\user;

use modules\management\forms\ScheduleForm;
use modules\management\models\Schedule;
use modules\management\services\ScheduleService;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class ScheduleController extends Controller
{
    private $service;

    public function __construct($id, $module, ScheduleService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function actionIndex()
    {
        $model = $this->findModel() ?? null;
        $form = new ScheduleForm($model, $this->getUserId());
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->save($form);
                Yii::$app->session->setFlash('success', "Успешно ".($model ? 'обновлено': 'добавлено'));
            } catch (\Exception $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('index', [
            'model' => $form,
            'schedule' => $model
        ]);
    }

    protected function findModel(): ?Schedule
    {
        return Schedule::findOne([ 'user_id' => $this->getUserId()]);
    }

    private function getUserId()
    {
        return  Yii::$app->user->identity->getId();
    }


}