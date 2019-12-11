<?php


namespace common\sending\services;



use common\sending\forms\SendingForm;
use common\sending\models\Sending;
use common\sending\repositories\SendingRepository;

class SendingService
{
    private $repository;

    public function __construct(SendingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(SendingForm $form)
    {
        $model = Sending::create($form);
        $this->repository->save($model);
    }

    public function edit($id, SendingForm $form)
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