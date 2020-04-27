<?php
namespace modules\entrant\controllers;

use modules\entrant\forms\AdditionalInformationForm;
use modules\entrant\models\AdditionalInformation;
use modules\entrant\services\AdditionalInformationService;
use yii\web\Controller;
use Yii;

class AdditionalInformationController extends Controller
{
    private $service;

    public function __construct($id, $module, AdditionalInformationService $service, $config = [])
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
        $form = new AdditionalInformationForm($model);
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
            'additional' => $model
        ]);
    }

    protected function findModel(): ?AdditionalInformation
    {
      return AdditionalInformation::findOne([ 'user_id' => Yii::$app->user->identity->getId()]);
    }
}