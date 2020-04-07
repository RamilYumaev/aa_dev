<?php


namespace modules\entrant\controllers;


use common\helpers\EduYearHelper;
use modules\entrant\forms\AgreementForm;
use modules\entrant\models\Agreement;
use modules\entrant\services\AgreementService;
use yii\web\Controller;
use Yii;

class AgreementController extends Controller
{
    private $service;

    public function __construct($id, $module, AgreementService $service, $config = [])
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
        $form = new AgreementForm($model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->createOrUpdate($form, $model);
                return $this->redirect(['anketa/step2']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('index', [
            'model' => $form,
            'agreement' => $model
        ]);
    }

    protected function findModel(): ?Agreement
    {
      return Agreement::findOne([ 'user_id' => Yii::$app->user->identity->getId(), 'year' =>EduYearHelper::eduYear()]);
    }
}