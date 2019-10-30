<?php


namespace backend\controllers\dictionary;

use dictionary\forms\DisciplineCompetitiveGroupForm;
use dictionary\models\DisciplineCompetitiveGroup;
use dictionary\services\DisciplineCompetitiveGroupService;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

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
     * @param $discipline_id
     * @param $competitive_group_id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($discipline_id, $competitive_group_id)
    {
        $model = $this->findModel($discipline_id, $competitive_group_id);
        $form = new DisciplineCompetitiveGroupForm($model->competitive_group_id, $model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($form);
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
     * @param $discipline_id
     * @param $competitive_group_id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($discipline_id, $competitive_group_id): DisciplineCompetitiveGroup
    {
        if (($model = DisciplineCompetitiveGroup::findOne(['discipline_id'=>$discipline_id, 'competitive_group_id'=>$competitive_group_id ])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param $discipline_id
     * @param $competitive_group_id
     * @return mixed
     */
    public function actionDelete($discipline_id, $competitive_group_id)
    {
        try {
            $this->service->remove($discipline_id, $competitive_group_id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['/dictionary/dict-competitive-group/view', 'id'=> $competitive_group_id]);
    }

}