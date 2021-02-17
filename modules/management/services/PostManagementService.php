<?php


namespace modules\management\services;


use common\transactions\TransactionManager;
use modules\management\forms\PostManagementForm;
use modules\management\models\ManagementTask;
use modules\management\models\PostManagement;
use modules\management\repositories\ManagementTaskRepository;
use modules\management\repositories\PostManagementRepository;
use modules\usecase\ServicesClass;
use yii\base\Model;


class PostManagementService extends ServicesClass
{
    private $managementTaskRepository, $transactionManager;

    public function __construct(PostManagementRepository $repository,
                                ManagementTaskRepository $managementTaskRepository,
                                TransactionManager $transactionManager,
                                PostManagement $model)
    {
        $this->repository = $repository;
        $this->model = $model;
        $this->transactionManager =$transactionManager;
        $this->managementTaskRepository = $managementTaskRepository;
    }
}