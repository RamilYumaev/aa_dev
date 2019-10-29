<?php


namespace dictionary\services;


use dictionary\forms\DisciplineCompetitiveGroupForm;
use dictionary\models\DisciplineCompetitiveGroup;
use dictionary\repositories\DictCompetitiveGroupRepository;
use dictionary\repositories\DictDisciplineRepository;
use dictionary\repositories\DisciplineCompetitiveGroupRepository;

class DisciplineCompetitiveGroupService
{
    private $repository;
    private $competitiveGroupRepository;
    private $disciplineRepository;

    public function __construct(DisciplineCompetitiveGroupRepository $repository,
                                DictCompetitiveGroupRepository $competitiveGroupRepository,
                                DictDisciplineRepository $disciplineRepository)
    {
        $this->repository = $repository;
        $this->competitiveGroupRepository = $competitiveGroupRepository;
        $this->disciplineRepository = $disciplineRepository;
    }

    public function create(DisciplineCompetitiveGroupForm $form)
    {
        $discipline = $this->disciplineRepository->get($form->discipline_id);
        $competitiveGroup = $this->competitiveGroupRepository->get($form->competitive_group_id);
        $model = DisciplineCompetitiveGroup::create($discipline->id, $competitiveGroup->id, $form->priority);
        $this->repository->save($model);
        return $model;
    }

    public function edit($id, DisciplineCompetitiveGroupForm $form)
    {
        $model = $this->repository->get($id);
        $discipline = $this->disciplineRepository->get($form->discipline_id);
        $competitiveGroup = $this->competitiveGroupRepository->get($form->competitive_group_id);
        $model->edit($discipline->id, $competitiveGroup->id, $form->priority);
        $this->repository->save($model);
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }

}