<?php


namespace modules\entrant\controllers;

use modules\entrant\forms\CseSubjectResultForm;
use modules\entrant\models\CseSubjectResult;
use modules\entrant\services\CseSubjectResultService;
use yii\base\Model;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class CseSubjectResultController extends Controller
{
    private $service;

    public function __construct($id, $module, CseSubjectResultService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
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

    /**
     *
     * @return mixed
     */

    public function actionCreate()
    {
        $form = new CseSubjectResultForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $form->resultData = $form->isArrayMoreResult();
            if (Model::loadMultiple($form->resultData, Yii::$app->request->post()) &&
                Model::validateMultiple($form->resultData)) {
                try {
                    $this->service->create($form);
                    return $this->redirect(['default/index']);
                } catch (\DomainException $e) {
                    Yii::$app->errorHandler->logException($e);
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $form = new CseSubjectResultForm($model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $form->resultData = $form->isArrayMoreResult();
            if (Model::loadMultiple($form->resultData, Yii::$app->request->post()) &&
                Model::validateMultiple($form->resultData)) {
                try {
                    $this->service->edit($model->id, $form);
                    return $this->redirect(['default/index']);
                } catch (\DomainException $e) {
                    Yii::$app->errorHandler->logException($e);
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }
        }
        return $this->render('update', [
            'model' => $form,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): CseSubjectResult
    {
        if (($model = CseSubjectResult::findOne(['id'=>$id, 'user_id' => Yii::$app->user->identity->getId()])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }


    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $this->service->remove($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['default/index']);
    }
}