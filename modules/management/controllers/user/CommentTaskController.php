<?php

namespace modules\management\controllers\user;
use modules\management\forms\CommentTaskForm;
use modules\management\models\Task;
use modules\management\services\CommentTaskService;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CommentTaskController extends Controller
{
    private $service;
    public function __construct($id, $module, CommentTaskService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionCreate($id)
    {
        $model = $this->findModel($id);
        $form = new CommentTaskForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->create($form, $model->id, Yii::$app->user->identity->getId());
                return $this->redirect(Yii::$app->request->referrer);
            } catch (\Exception $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->renderAjax('@modules/management/views/admin/comment-task/_comment', [
            'model' => $form,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): Task
    {
        if (($model = Task::findOne(['id'=>$id, 'responsible_user_id'=> Yii::$app->user->identity->getId()])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }
}