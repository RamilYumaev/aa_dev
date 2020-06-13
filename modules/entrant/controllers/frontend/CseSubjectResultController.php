<?php


namespace modules\entrant\controllers\frontend;

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\behaviors\AnketaRedirectBehavior;
use modules\entrant\forms\CseSubjectResultForm;
use modules\entrant\forms\ExaminationOrCseForm;
use modules\entrant\helpers\CseSubjectHelper;
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
            [
            'class'=> AnketaRedirectBehavior::class,
            'ids'=>['update','delete']]
        ];
    }

    /**
     *
     * @return mixed
     */

    public function actionCreate()
    {
        $form = new CseSubjectResultForm($this->getUserId());
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $form->resultData = $form->isArrayMoreResult();
            if (Model::loadMultiple($form->resultData, Yii::$app->request->post()) &&
                Model::validateMultiple($form->resultData)) {
                try {
                    $this->service->create($form);
                    return $this->redirect(['default/cse']);
                } catch (\DomainException $e) {
                    Yii::$app->errorHandler->logException($e);
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }
        }
        return $this->render('create', [
            'model' => $form,
            'isKeys' => CseSubjectHelper::listSubject($this->getUserId())
        ]);
    }

    /**
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionCseVi()
    {
        if (DictCompetitiveGroupHelper::bachelorExistsUser($this->getUserId())
            && !\modules\entrant\helpers\CseSubjectHelper::cseSubjectExists($this->getUserId())) {
               return $this->render('cse-vi');
            }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        \Yii::$app->session->setFlash("warning", "Редактирование предметов приведет к удалению выбранных образовательных 
        программ бакалавриата");

        $model = $this->findModel($id);
        $form = new CseSubjectResultForm($model->user_id, $model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $form->resultData = $form->isArrayMoreResult();
            if (Model::loadMultiple($form->resultData, Yii::$app->request->post()) &&
                Model::validateMultiple($form->resultData)) {
                try {
                    $this->service->edit($model->id, $form);
                    return $this->redirect(['default/cse']);
                } catch (\DomainException $e) {
                    Yii::$app->errorHandler->logException($e);
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }
        }
        return $this->render('update', [
            'model' => $form,
            'isKeys' => array_diff(CseSubjectHelper::listSubject($this->getUserId()), $model->keySubject())
        ,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): CseSubjectResult
    {
        if (($model = CseSubjectResult::findOne(['id'=>$id, 'user_id' => $this->getUserId()])) !== null) {
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
        return $this->redirect(['default/cse']);
    }

    private function getUserId()
    {
        return  Yii::$app->user->identity->getId();
    }
}