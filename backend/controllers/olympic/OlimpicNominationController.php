<?php


namespace backend\controllers\olympic;

use olympic\forms\OlimpicNominationCreateForm;
use olympic\forms\OlimpicNominationEditForm;
use olympic\models\OlimpicNomination;
use olympic\services\OlimpicNominationService;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class OlimpicNominationController extends Controller
{
    private $service;

    public function __construct($id, $module, OlimpicNominationService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionCreate($olimpic_id)
    {
        $form = new OlimpicNominationCreateForm($olimpic_id);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
              $model =  $this->service->create($form);
              return $this->redirect(['/olympic/olimpic-list/view', 'id'=> $model->olimpic_id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->renderAjax('create', [
            'model' => $form,
        ]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $form = new OlimpicNominationEditForm($model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($form);
                return $this->redirect(['/olympic/olimpic-list/view', 'id'=> $model->olimpic_id ]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->renderAjax('update', [
            'model' => $form,
            'olimpicNomination' => $model,
        ]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): OlimpicNomination
    {
        if (($model = OlimpicNomination::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        try {
            $this->service->remove($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['/olympic/olimpic-list/view', 'id'=>$model->olimpic_id ]);
    }

}