<?php


namespace common\sending\services;



use common\sending\forms\SendingCreateForm;
use common\sending\forms\SendingEditForm;
use common\sending\models\Sending;
use common\sending\repositories\SendingRepository;

class SendingService
{
    private $repository;

    public function __construct(SendingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(SendingCreateForm $form)
    {
        $model = Sending::create($form);
        $this->repository->save($model);
    }

    public function edit($id, SendingEditForm $form)
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