<?php


namespace modules\entrant\controllers\backend;


use modules\entrant\forms\FIOLatinForm;
use modules\entrant\models\FIOLatin;
use modules\entrant\services\FioLatinService;
use yii\web\Controller;
use Yii;

class FioLatinController extends Controller
{
    private $service;

    public function __construct($id, $module, FioLatinService $service, $config = [])
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
        $form = new FIOLatinForm($model);
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
            'fio' => $model
        ]);
    }

    protected function findModel(): ?FIOLatin
    {
      return FIOLatin::findOne([ 'user_id' => Yii::$app->user->identity->getId()]);
    }
}