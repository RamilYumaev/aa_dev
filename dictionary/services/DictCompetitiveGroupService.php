<?php


namespace dictionary\services;


use dictionary\forms\DictCompetitiveGroupEditForm;
use dictionary\forms\DictCompetitiveGroupCreateForm;
use dictionary\models\DictCompetitiveGroup;
use dictionary\models\DisciplineCompetitiveGroup;
use dictionary\repositories\DictCompetitiveGroupRepository;
use dictionary\repositories\DictSpecialityRepository;
use dictionary\repositories\DictSpecializationRepository;
use dictionary\repositories\FacultyRepository;

class DictCompetitiveGroupService
{
    private $repository;
    private $facultyRepository;
    private $specialityRepository;
    private $specializationRepository;

    public function __construct(
        DictCompetitiveGroupRepository $repository,
        FacultyRepository $facultyRepository,
        DictSpecialityRepository $specialityRepository,
        DictSpecializationRepository $specializationRepository)
    {
        $this->repository = $repository;
        $this->facultyRepository = $facultyRepository;
        $this->specialityRepository = $specialityRepository;
        $this->specializationRepository = $specializationRepository;
    }

    public function create(DictCompetitiveGroupCreateForm $form)
    {
        $faculty = $this->facultyRepository->get($form->faculty_id);
        $speciality = $this->specialityRepository->get($form->speciality_id);
        $specialization = $this->specializationRepository->get($form->specialization_id);

        $model = DictCompetitiveGroup::create($form, $faculty->id, $speciality->id, $specialization->id);
        $this->repository->save($model);
        return $model;
    }

    public function edit($id, DictCompetitiveGroupEditForm $form)
    {
        $faculty = $this->facultyRepository->get($form->faculty_id);
        $speciality = $this->specialityRepository->get($form->speciality_id);
        $specialization = $this->specializationRepository->get($form->specialization_id);

        $model = $this->repository->get($id);
        $model->edit($form, $faculty->id, $speciality->id, $specialization->id);
        $this->repository->save($model);
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        DisciplineCompetitiveGroup::deleteAll(['competitive_group_id'=> $model->id]);
        $this->repository->remove($model);
    }

}