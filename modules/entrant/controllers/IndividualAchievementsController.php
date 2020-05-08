<?php

namespace modules\entrant\controllers;


use modules\dictionary\forms\DictIndividualAchievementForm;
use modules\dictionary\models\DictIndividualAchievement;
use modules\dictionary\services\DictIndividualAchievementService;
use modules\entrant\forms\OtherDocumentForm;
use modules\entrant\models\UserIndividualAchievements;
use modules\entrant\services\IndividualAchievementService;
use yii\bootstrap\ActiveForm;
use yii\web\Controller;
use yii\filters\VerbFilter;
use Yii;
use yii\web\Response;

class IndividualAchievementsController extends Controller
{
    private $service;

    public function __construct($id, $module, IndividualAchievementService $service, $config = [])
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
        $model = DictIndividualAchievement::getFilteredByUserIndividualAchievement();

        return $this->render("index", ["model" => $model]);
    }

    public function actionSave($id)
    {
        $form = new OtherDocumentForm(true);

        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->create($id, $form);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->renderAjax("@modules/entrant/views/other-document/_form", ["model" => $form]);

    }

    public function actionRemove($id)
    {
        try {
            $this->service->remove($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(["index"]);
    }


}