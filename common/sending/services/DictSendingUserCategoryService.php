<?php


namespace common\sending\services;



use common\sending\forms\DictSendingUserCategoryCreateForm;
use common\sending\forms\DictSendingUserCategoryEditForm;
use common\sending\forms\DictSendingUserCategoryForm;
use common\sending\models\DictSendingUserCategory;
use common\sending\repositories\DictSendingUserCategoryRepository;

class DictSendingUserCategoryService
{
    private $repository;

    public function __construct(DictSendingUserCategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(DictSendingUserCategoryCreateForm $form)
    {
        $model = DictSendingUserCategory::create($form);
        $this->repository->save($model);
    }

    public function edit($id, DictSendingUserCategoryEditForm $form)
    {
        $model = $this->repository->get($id);
        $model->edit($form);
        $this->repository->save($model);
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }
}