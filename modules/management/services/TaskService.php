<?php


namespace modules\management\services;


use modules\management\models\Task;
use modules\management\repositories\TaskRepository;
use modules\management\searches\TaskSearch;
use modules\usecase\ServicesClass;
use olympic\models\auth\Profiles;
use yii\base\Model;


class TaskService extends ServicesClass
{

    public function __construct(TaskRepository $repository, Task $model)
    {
        $this->repository = $repository;
        $this->model = $model;
    }

    public function status($id, $status)
    {
        $model = $this->repository->get($id);
        $model->setStatus($status);
        $this->repository->save($model);
    }

    public function create(Model $form)
    {
       $model = parent::create($form);
       $text = "У Вас новая задача";
       $this->sendEmailTask($model->responsibleProfile, $model->responsibleSchedule->email, $text, $model->subjectEmail)->send();
       return $model;
    }

    private function sendEmailTask(Profiles $profile, $email, $text, $subject)
    {
        $mailer = \Yii::$app->taskMailer;

        $configTemplate =  ['html' => 'task/newTask-html', 'text' => 'task/newTask-text'];
        $configData = ['profile' => $profile, 'text' => $text];
        return $mailer
            ->mailer()
            ->compose($configTemplate, $configData)
            ->setFrom([$mailer->getFromSender() => 'МПГУ робот'])
            ->setTo($email)
            ->setSubject($subject);
    }

    public function rework($id, $note)
    {
        $model = $this->repository->get($id);
        $model->setStatus(Task::STATUS_REWORK);
        $model->setNote($note);
        $this->repository->save($model);
        $text ='Причина доработки: '. $model->note;
        $this->sendEmailTask($model->responsibleProfile, $model->responsibleSchedule->email, $text, $model->subjectEmail)->send();
    }

}