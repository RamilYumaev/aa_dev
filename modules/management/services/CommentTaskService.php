<?php


namespace modules\management\services;

use common\transactions\TransactionManager;
use modules\management\forms\CommentTaskForm;
use modules\management\forms\ScheduleForm;
use modules\management\models\CommentTask;
use modules\management\models\ManagementUser;
use modules\management\models\PostRateDepartment;
use modules\management\models\Schedule;
use modules\management\models\Task;
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
        /** @var Task $task */
        $task = $this->tasKRepository->get($task_id);
        $this->commentClose($task);
        $model = CommentTask::create($form->text, $task_id, $user_id);
        $this->repository->save($model);

        $this->sendEmailTask($model, $task, $user_id);
        return $model;
    }

    public function  edit(CommentTaskForm $form, $id)
    {
        $model = $this->repository->get($id);
        /** @var Task $task */
        $task = $this->tasKRepository->get($model->task_id);
        $this->commentClose($task);
        $model->setText($form->text);
        $this->repository->save($model);
        return $model;
    }

    private function commentClose(Task $task) {
        if ($task->isStatusesAccepted()){
            throw  new \DomainException('Вы не можете добавить/редактировать комментарий, так как задача имеет статус "Принято"');
        }
    }

    private function sendEmailTask(CommentTask $commentTask, Task $task, $user_id)
    {
        if($task->responsible_user_id === $user_id  && $task->director_user_id === $user_id) {
            return true;
        }
        if ($task->director_user_id == $user_id) {
            $email = $task->responsibleSchedule->email;
            $profile =  $task->responsibleProfile;
        }else {
            $email =  $task->directorSchedule->email;
            $profile =  $task->directorProfile;
        }
        $mailer = \Yii::$app->taskMailer;
        /** @var Task $model */
        $configTemplate =  ['html' => 'task/newComment-html', 'text' => 'task/newComment-text'];
        $configData = ['commentTask' => $commentTask,  'profile'=> $profile];
        $mailer
            ->mailer()
            ->compose($configTemplate, $configData)
            ->setFrom([$mailer->getFromSender() => 'МПГУ робот'])
            ->setTo($email)
            ->setSubject("Новый комментарий")->send();
    }
}