<?php


namespace olympic\services;

use common\transactions\TransactionManager;
use dictionary\repositories\DictChairmansRepository;
use dictionary\repositories\DictClassRepository;
use dictionary\repositories\DictCompetitiveGroupRepository;
use dictionary\repositories\FacultyRepository;
use olympic\forms\OlimpicListCopyForm;
use olympic\forms\OlimpicListCreateForm;
use olympic\forms\OlimpicListEditForm;
use olympic\helpers\OlympicHelper;
use olympic\models\ClassAndOlympic;
use olympic\models\OlimpicCg;
use olympic\models\OlimpicList;
use olympic\models\Olympic;
use olympic\repositories\OlimpicListRepository;
use olympic\repositories\OlympicRepository;

class OlimpicListService
{
    private $repository;
    private $facultyRepository;
    private $olympicRepository;
    private $chairmansRepository;
    private $competitiveGroupRepository;
    private $transaction;
    public $classRepository;

    public function __construct(
        OlimpicListRepository $repository,
        OlympicRepository $olympicRepository,
        FacultyRepository $facultyRepository,
        DictChairmansRepository $chairmansRepository,
        DictClassRepository $classRepository,
        DictCompetitiveGroupRepository $competitiveGroupRepository,
        TransactionManager $transaction
    )
    {
        $this->repository = $repository;
        $this->olympicRepository = $olympicRepository;
        $this->facultyRepository = $facultyRepository;
        $this->chairmansRepository = $chairmansRepository;
        $this->competitiveGroupRepository = $competitiveGroupRepository;
        $this->transaction = $transaction;
        $this->classRepository = $classRepository;
    }

    public function create(OlimpicListCreateForm $form)
    {
        $faculty = $form->faculty_id ? $this->facultyRepository->get($form->faculty_id) : null;
        $chairman = $form->chairman_id ? $this->chairmansRepository->get($form->chairman_id) : null;

        $olympic = $this->olympicRepository->get($form->olimpic_id);
        $model = OlimpicList::create($form, $chairman->id ?? null, $faculty->id ?? null, $olympic->id);
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

        return $model;
    }

    public function copy(OlimpicListCopyForm $form)
    {
        $faculty = $form->faculty_id ? $this->facultyRepository->get($form->faculty_id) : null;
        $chairman = $form->chairman_id ? $this->chairmansRepository->get($form->chairman_id) : null;

        $olympic = $this->olympicRepository->get($form->olimpic_id);

        $model = OlimpicList::copy($form, $chairman->id ?? null, $faculty->id ?? null, $olympic->id);
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
        return $model;
    }

    public function edit($id, OlimpicListEditForm $form)
    {
        $faculty = $form->faculty_id ? $this->facultyRepository->get($form->faculty_id) : null;
        $chairman = $form->chairman_id ? $this->chairmansRepository->get($form->chairman_id) : null;

        $olympic = $this->olympicRepository->get($form->olimpic_id);
        $model = $this->repository->get($id);

        $model->edit($form, $chairman->id ?? null, $faculty->id ?? null, $olympic->id);
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

    private function deleteRelation($id)
    {
        OlimpicCg::deleteAll(['olimpic_id' => $id]);
        ClassAndOlympic::deleteAll(['olympic_id' => $id]);
    }

}