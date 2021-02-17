<?php


namespace modules\management\services;


use common\transactions\TransactionManager;
use modules\management\forms\PostRateDepartmentForm;
use modules\management\models\ManagementTask;
use modules\management\models\PostRateDepartment;
use modules\management\repositories\ManagementTaskRepository;
use modules\management\repositories\PostRateDepartmentRepository;
use modules\usecase\ServicesClass;
use yii\base\Model;


class PostRateDepartmentService extends ServicesClass
{
    private $managementTaskRepository, $transactionManager;

    public function __construct(PostRateDepartmentRepository $repository,
                                ManagementTaskRepository $managementTaskRepository,
                                TransactionManager $transactionManager,
                                PostRateDepartment $model)
    {
        $this->repository = $repository;
        $this->model = $model;
        $this->transactionManager =$transactionManager;
        $this->managementTaskRepository = $managementTaskRepository;
    }

    public function create(Model $form)
    {
        $this->transactionManager->wrap(function () use ($form) {
            $model = parent::create($form);
            $this->saveManagementTask($form, $model->id);
        });
    }

    private function saveManagementTask(Model $form, $id) {
        /** @var  $form PostRateDepartmentForm */
        if ($form->taskList) {
            foreach ($form->taskList as $task) {
                $managementTak = ManagementTask::create($id, $task);
                $this->managementTaskRepository->save($managementTak);
            }
        }
    }

    public function edit($id, Model $form)
    {
        $this->transactionManager->wrap(function () use ($id, $form) {
            parent::edit($id, $form);
            $this->deleteRelation($id);
            $this->saveManagementTask($form, $id);
        });
    }

    private function deleteRelation($id)
    {
        ManagementTask::deleteAll(['post_rate_id' => $id]);
    }

}