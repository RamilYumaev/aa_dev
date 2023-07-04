<?php
namespace modules\entrant\controllers\frontend;

use modules\entrant\forms\AverageScopeSpoForm;
use modules\entrant\models\AverageScopeSpo;
use modules\entrant\services\AverageScopeSpoService;
use yii\web\Controller;
use Yii;

class AverageScopeSpoController extends Controller
{
    private $service;

    public function __construct($id, $module, AverageScopeSpoService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $model = $this->findModel() ?? null;
        $form = new AverageScopeSpoForm($model);
        $form->user_id = $this->getUserId();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->createOrUpdate($form);
                return $this->redirect(['default/index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('index', [
            'model' => $form,
            'averageSpo' => $model,
        ]);
    }

    protected function findModel(): ?AverageScopeSpo
    {
      return AverageScopeSpo::findOne([ 'user_id' => $this->getUserId() ]);
    }

    private function getUserId()
    {
        return Yii::$app->user->identity->getId();
    }
}