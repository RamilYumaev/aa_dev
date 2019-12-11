<?php


namespace common\sending\services;

use common\sending\forms\DictSendingTemplateForm;
use common\sending\models\DictSendingTemplate;
use common\sending\repositories\DictSendingTemplateRepository;

class DictSendingTemplateService
{
    private $repository;

    public function __construct(DictSendingTemplateRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(DictSendingTemplateForm $form)
    {
        $model = DictSendingTemplate::create($form);
        $this->repository->save($model);
    }

    public function edit($id, DictSendingTemplateForm $form)
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