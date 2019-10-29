<?php


namespace backend\controllers\dictionary;

use dictionary\forms\DisciplineCompetitiveGroupForm;
use dictionary\models\DisciplineCompetitiveGroup;
use dictionary\services\DisciplineCompetitiveGroupService;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;

class DisciplineCompetitiveGroupController extends Controller
{
    private $service;

    public function __construct($id, $module, DisciplineCompetitiveGroupService $service, $config = [])
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
    public function actionCreate($competitive_group_id)
    {
        $form = new DisciplineCompetitiveGroupForm($competitive_group_id);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
              $this->service->create($form);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(['/dictionary/dict-competitive-group/view', 'id'=> $form->competitive_group_id]);
        }
        return $this->renderAjax('create', [
            'model' => $form,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $form = new DisciplineCompetitiveGroupForm($model->competitive_group_id, $model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($model->id, $form);
                return $this->redirect(['/dictionary/dict-competitive-group/view', 'id'=>$form->competitive_group_id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->renderAjax('update', [
            'model' => $form,
            'disciplineCompetitiveGroup' => $model,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    protected function findModel($id): DisciplineCompetitiveGroup
    {
        if (($model = DisciplineCompetitiveGroup::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        try {
            $this->service->remove($model->id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['/dictionary/dict-competitive-group/view', 'id'=> $model->competitive_group_id]);
    }

}