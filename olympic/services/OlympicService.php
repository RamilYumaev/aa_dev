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
    private $facultyRepository;
    private $chairmansRepository;
    private $competitiveGroupRepository;
    private $transaction;
    public  $classRepository;

    public function __construct(
        OlympicRepository $repository,
        FacultyRepository $facultyRepository,
        DictChairmansRepository $chairmansRepository,
        DictClassRepository $classRepository,
        DictCompetitiveGroupRepository $competitiveGroupRepository,
        TransactionManager $transaction
    )
    {
        $this->repository = $repository;
        $this->facultyRepository = $facultyRepository;
        $this->chairmansRepository = $chairmansRepository;
        $this->competitiveGroupRepository = $competitiveGroupRepository;
        $this->transaction = $transaction;
        $this->classRepository = $classRepository;
    }

    public function create(OlympicCreateForm $form)
    {
        $faculty = $this->facultyRepository->get($form->faculty_id);
        $chairman = $this->chairmansRepository->get($form->chairman_id);

        $model = Olympic::create($form, $faculty->id, $chairman->id);
        try {
            $this->transaction->wrap(function () use ($model, $form) {
                $this->repository->save($model);
                if ($form->competitiveGroupsList) {
                    foreach ($form->competitiveGroupsList as $cg) {
                        $competitiveGroup = $this->competitiveGroupRepository->get($cg);
                        $cgOlympic = OlimpicCg::create($model->id, $competitiveGroup->id);
                        $cgOlympic->save(false);
                    }
                }
                if ($form->classesList) {
                    foreach ($form->classesList as $class) {
                        $dictClass = $this->classRepository->get($class);
                        $classOlympic = ClassAndOlympic::create($dictClass->id, $model->id);
                        $classOlympic->save(false);
                    }
                }
            });
        } catch (\Exception $e) {
        }

        return $model;
    }

    public function edit($id, OlympicEditForm $form)
    {
        $faculty = $this->facultyRepository->get($form->faculty_id);
        $chairman = $this->chairmansRepository->get($form->chairman_id);
        $model = $this->repository->get($id);

        $model->edit($form, $faculty->id, $chairman->id);
        try {
            $this->transaction->wrap(function () use ($model, $form) {
                $this->deleteRelation($model->id);
                if ($form->competitiveGroupsList) {
                    foreach ($form->competitiveGroupsList as $cg) {
                        $competitiveGroup = $this->competitiveGroupRepository->get($cg);
                        $cgOlympic = OlimpicCg::create($model->id, $competitiveGroup->id);
                        $cgOlympic->save(false);
                    }
                }
                if ($form->classesList) {
                    foreach ($form->classesList as $class) {
                        $dictClass = $this->classRepository->get($class);
                        $classOlympic = ClassAndOlympic::create($dictClass->id, $model->id);
                        $classOlympic->save(false);
                    }
                }

                 $this->repository->save($model);
            });
        } catch (\Exception $e) {
        }

    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->deleteRelation($model->id);
        $this->repository->remove($model);
    }

    private function deleteRelation($id) {
        OlimpicCg::deleteAll(['olimpic_id'=> $id]);
        ClassAndOlympic::deleteAll(['olympic_id'=> $id]);
    }

}