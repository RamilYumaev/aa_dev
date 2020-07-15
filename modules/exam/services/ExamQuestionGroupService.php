<?php
namespace modules\exam\services;

use modules\exam\forms\ExamQuestionGroupForm;
use modules\exam\models\ExamQuestionGroup;
use modules\exam\repositories\ExamQuestionGroupRepository;
use function GuzzleHttp\Promise\all;

class ExamQuestionGroupService
{
    private $repository;

    public function __construct(ExamQuestionGroupRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(ExamQuestionGroupForm $form)
    {
        $model  = ExamQuestionGroup::create($form);
        $this->repository->save($model);
        return $model;
    }

    public function edit($id, ExamQuestionGroupForm $form)
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

    public function getAll($discipline)
    {
        $result = [];
        foreach (ExamQuestionGroup::find()->where(['discipline_id'=> $discipline])->all() as $value) {
            $result[] = [
                'id' => $value->id,
                'text' => $value->name,
            ];
        }
        return $result;

    }

}