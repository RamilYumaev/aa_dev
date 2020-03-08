<?php


namespace modules\entrant\services;

use modules\entrant\forms\OtherDocumentForm;
use modules\entrant\models\OtherDocument;
use modules\entrant\repositories\OtherDocumentRepository;

class OtherDocumentService
{
    private $repository;

    public function __construct(OtherDocumentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(OtherDocumentForm $form)
    {
        $model  = OtherDocument::create($form);
        $this->repository->save($model);
        return $model;
    }

    public function edit($id, OtherDocumentForm $form)
    {
        $model = $this->repository->get($id);
        $model->data($form);
        $model->save($model);
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }

}