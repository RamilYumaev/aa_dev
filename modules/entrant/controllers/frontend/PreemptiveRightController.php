<?php

namespace modules\entrant\controllers\frontend;

use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\entrant\forms\OtherDocumentForm;
use modules\entrant\services\PreemptiveRightService;
use yii\bootstrap\ActiveForm;
use yii\web\Controller;
use yii\filters\VerbFilter;
use Yii;
use yii\web\Response;

class PreemptiveRightController extends Controller
{
    private $service;

    public function __construct($id, $module, PreemptiveRightService $service, $config = [])
    {
        $this->service = $service;

        parent::__construct($id, $module, $config);
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

    public function actionIndex()
    {
        return $this->render("index",['userId' => $this->getUserId()]);
    }

    public function actionCreate($id)
    {
        $form = new OtherDocumentForm($this->getUserId(), true, null, false, ['authority','date'], [DictIncomingDocumentTypeHelper::TYPE_OTHER]);
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->create($form, $id);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect('index');
        }
        return $this->render("create", ["model" => $form]);
    }

    public function actionRemove($otherId, $id)
    {
        try {
            $this->service->remove($otherId, $id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(["index"]);
    }

    public function actionAdd($id)
    {
        $other_id = Yii::$app->request->post('other_id');
        if ($other_id) {
            try {
                $this->service->add($other_id, $id);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('add',['userId' => $this->getUserId()]);
    }

    private function getUserId()
    {
        return  Yii::$app->user->identity->getId();
    }



}