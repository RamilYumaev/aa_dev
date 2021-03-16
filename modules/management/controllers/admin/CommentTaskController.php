<?php

namespace modules\management\controllers\admin;
use modules\management\forms\CommentTaskForm;
use modules\management\models\CommentTask;
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

    public function actionCreate($id)
    {
        $form = new CommentTaskForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->create($form, $id, Yii::$app->user->identity->getId());
                return $this->redirect(Yii::$app->request->referrer);
            } catch (\Exception $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->renderAjax('_comment', [
            'model' => $form,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id, $task_id)
    {
        $userId = Yii::$app->user->identity->getId();
        $comment = CommentTask::findOne(['id' => $id,'created_by' => $userId, 'task_id' =>$task_id]);
        if(!$comment) {
            throw new  NotFoundHttpException('Такой комментарий не найден');
        }
        $form = new CommentTaskForm($comment);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($form, $comment->id);
                return $this->redirect(Yii::$app->request->referrer);
            } catch (\Exception $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->renderAjax('_comment', [
            'model' => $form,
        ]);
    }
}