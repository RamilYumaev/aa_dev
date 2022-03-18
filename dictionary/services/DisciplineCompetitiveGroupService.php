<?php


namespace dictionary\services;


use dictionary\forms\DisciplineCompetitiveGroupForm;
use dictionary\models\DictCompetitiveGroup;
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
        $disciplineSpoId = $this->isSpo($form->spo_discipline_id, $competitiveGroup);
        $model = DisciplineCompetitiveGroup::create($discipline->id, $competitiveGroup->id, $form->priority, $disciplineSpoId);
        $this->repository->save($model);
        return $model;
    }

    public function edit(DisciplineCompetitiveGroupForm $form)
    {
        $model = $this->repository->get($form->discipline_id, $form->competitive_group_id);
        $discipline = $this->disciplineRepository->get($form->discipline_id);
        $competitiveGroup = $this->competitiveGroupRepository->get($form->competitive_group_id);
        $disciplineSpoId = $this->isSpo($form->spo_discipline_id, $competitiveGroup);
        $model->edit($discipline->id, $competitiveGroup->id, $form->priority, $disciplineSpoId);
        $this->repository->save($model);
    }

    public function remove($discipline_id, $competitive_group_id)
    {
        $model = $this->repository->get($discipline_id, $competitive_group_id);
        $this->repository->remove($model);
    }

    private function isSpo($spo_discipline_id, DictCompetitiveGroup $dictCompetitiveGroup) {
        if($spo_discipline_id) {
            if(!$dictCompetitiveGroup->isBachelor()) {
                throw new \DomainException('Вы не можете добавить спецальную дисцплину СПО. Ее можно добавить только для бакалавриата');
            }
            $disciplineSpo = $this->disciplineRepository->get($spo_discipline_id);
            return $disciplineSpo->id;
        }
        return null;
    }

}