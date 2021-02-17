<?php


namespace modules\management\services;

use common\transactions\TransactionManager;
use modules\management\forms\CommentTaskForm;
use modules\management\forms\ScheduleForm;
use modules\management\models\CommentTask;
use modules\management\models\ManagementUser;
use modules\management\models\PostRateDepartment;
use modules\management\models\Schedule;
use modules\management\repositories\CommentTaskRepository;
use modules\management\repositories\ManagementUserRepository;
use modules\management\repositories\ScheduleRepository;
use modules\management\repositories\TaskRepository;
use yii\base\Model;

class CommentTaskService
{
    private $repository;
    private $tasKRepository;

    public function __construct(CommentTaskRepository $repository, TaskRepository $taskRepository)
    {
        $this->repository = $repository;
        $this->tasKRepository = $taskRepository;
    }

    /**
     * @throws \Exception
     */

    public function create(CommentTaskForm $form, $task_id, $user_id)
    {
        $this->tasKRepository->get($task_id);
        $model = CommentTask::create($form->text, $task_id, $user_id);
        $this->repository->save($model);
        return $model;
    }
}