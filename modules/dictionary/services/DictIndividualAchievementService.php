<?php


namespace modules\dictionary\services;

use modules\dictionary\forms\DictIndividualAchievementForm;
use modules\dictionary\models\DictIndividualAchievement;
use modules\dictionary\repositories\DictIndividualAchievementRepository;

class DictIndividualAchievementService
{
    private $repository;

    public function __construct(DictIndividualAchievementRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(DictIndividualAchievementForm $form)
    {
        $model  = DictIndividualAchievement::create($form);
        $this->repository->save($model);
        return $model;
    }

    public function edit($id, DictIndividualAchievementForm $form)
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