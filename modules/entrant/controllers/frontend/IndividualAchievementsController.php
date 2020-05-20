<?php

namespace modules\entrant\controllers\frontend;


use modules\dictionary\helpers\DictIndividualAchievementHelper;
use modules\dictionary\models\DictIndividualAchievement;
use modules\entrant\forms\OtherDocumentForm;
use modules\entrant\models\CseSubjectResult;
use modules\entrant\models\UserIndividualAchievements;
use modules\entrant\services\IndividualAchievementService;
use yii\bootstrap\ActiveForm;
use yii\web\Controller;
use yii\filters\VerbFilter;
use Yii;
use yii\web\NotFoundHttpException;
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
        $model = DictIndividualAchievementHelper::dictIndividualAchievementUser($this->getUser());

        return $this->render("index", ["model" => $model]);
    }

    public function actionSave($id)
    {
        $form = new OtherDocumentForm($this->getUser(), true, null, false, [], [], $id);
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

    /**
     * @param integer $individual_id
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionRemove($id)
    {
        $model = $this->findModel($id);
        try {
            $this->service->remove($model->id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(["index"]);
    }

    /**
     * @param integer $individual_id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($individual_id): UserIndividualAchievements
    {
        if (($model = UserIndividualAchievements::findOne(['individual_id'=>$individual_id, 'user_id' => $this->getUser()])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }

    private function getUser() {
        return Yii::$app->user->identity->getId();
    }



}