<?php


namespace olympic\services;

use common\transactions\TransactionManager;
use dictionary\models\DisciplineCompetitiveGroup;
use dictionary\repositories\DictChairmansRepository;
use dictionary\repositories\DictClassRepository;
use dictionary\repositories\DictCompetitiveGroupRepository;
use dictionary\repositories\FacultyRepository;
use olympic\forms\OlympicCreateForm;
use olympic\forms\OlympicEditForm;
use olympic\models\ClassAndOlympic;
use olympic\models\OlimpicCg;
use olympic\models\Olympic;
use olympic\repositories\OlympicRepository;

class OlympicService
{
    private $repository;

    public function __construct(OlympicRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(OlympicCreateForm $form)
    {
        $model = Olympic::create($form);
        $this->repository->save($model);
        return $model;
    }

    public function edit(OlympicEditForm $form)
    {
        $model = $this->repository->get($form->_olympic->id);
        $model->edit($form);
        $this->repository->save($model);
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }
}