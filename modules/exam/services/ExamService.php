<?php
namespace modules\exam\services;

use modules\exam\forms\ExamForm;
use modules\exam\models\Exam;
use modules\exam\repositories\ExamRepository;

class ExamService
{
    private $repository;

    public function __construct(ExamRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(ExamForm $form)
    {
        $model  = Exam::create($form);
        $this->repository->save($model);
        return $model;
    }

    public function edit($id, ExamForm $form)
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