<?php


namespace dictionary\services;


use dictionary\forms\DictCompetitiveGroupEditForm;
use dictionary\forms\DictCompetitiveGroupCreateForm;
use dictionary\helpers\DictCompetitiveGroupHelper;
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
//        $faculty = $this->facultyRepository->get($form->faculty_id);
//        $speciality = $this->specialityRepository->get($form->speciality_id);
//        $specialization = $this->specializationRepository->get($form->specialization_id);

        $model = DictCompetitiveGroup::create($form, $form->faculty_id, $form->speciality_id, $form->specialization_id);
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

    public function getAllCg ($levelId)
    {
        $model = DictCompetitiveGroup::find();
        if ($levelId == 1) {
            $model = $model->eduLevel(DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR);
        } elseif ($levelId == 2) {
            $model = $model->eduLevel( DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER);
        } elseif ($levelId == 3) {
            $model = $model->eduLevel(DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL);
        } else {
            $model = $model->eduLevel( DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO);
        }
        $result = [];
        foreach ($model->all() as $currentCg) {
            $result[] = [
                'id' => $currentCg->id,
                'text' => DictCompetitiveGroupHelper::getFullName($currentCg->year, $currentCg->edu_level,
                    $currentCg->speciality_id,
                    $currentCg->specialization_id,
                    $currentCg->faculty_id, $currentCg->education_form_id, $currentCg->financing_type_id) ,
            ];
        }
        return $result;
    }

    public function getAllFullCg($year, $educationLevelId, $educationFormId,
            $facultyId, $foreignerStatus, $financingTypeId)
    {$model = DictCompetitiveGroup::find()
            ->currentYear($year)
            ->eduLevel($educationLevelId)
            ->faculty($facultyId)
            ->finance($financingTypeId)
            ->formEdu($educationFormId)
            ->foreignerStatus($foreignerStatus);
        $result = [];
        foreach ($model->all() as $currentCg) {
            $result[] = [
                'id' => $currentCg->id,
                'text' => DictCompetitiveGroupHelper::getFullName($currentCg->year, $currentCg->edu_level,
                    $currentCg->speciality_id,
                    $currentCg->specialization_id,
                    $currentCg->faculty_id, $currentCg->education_form_id, $currentCg->financing_type_id),
            ];
        }
        return $result;
    }
}