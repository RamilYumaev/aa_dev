<?php
namespace modules\entrant\services;


use dictionary\repositories\DictDisciplineRepository;
use modules\dictionary\repositories\DictCseSubjectRepository;
use modules\dictionary\repositories\DictCtSubjectRepository;
use modules\entrant\forms\UserDisciplineCseForm;
use modules\entrant\models\UserDiscipline;
use modules\entrant\repositories\UserDisciplineRepository;

class UserDisciplineService
{
    private $repository;
    private $dictDisciplineRepository;
    private $ctSubjectRepository;
    private $cseSubjectRepository;

    public function __construct(UserDisciplineRepository $repository,
                                DictDisciplineRepository $dictDisciplineRepository,
                                DictCtSubjectRepository $ctSubjectRepository,
                                DictCseSubjectRepository $cseSubjectRepository)
    {
        $this->repository = $repository;
        $this->dictDisciplineRepository = $dictDisciplineRepository;
        $this->ctSubjectRepository = $ctSubjectRepository;
        $this->cseSubjectRepository = $cseSubjectRepository;
    }

    public function create(UserDisciplineCseForm $form)
    {
        $this->correctIdDiscipline($form);
        $model  = UserDiscipline::create($form);
        $this->repository->save($model);
        return $model;
    }

    public function createMore(array $forms) {
        /** @var UserDisciplineCseForm $form */
        foreach ($forms as $form) {
            if($id = $form->key) {
                $this->edit($id, $form);
            }else {
                $this->create($form);
            }
        }
    }

    public function edit($id, UserDisciplineCseForm $form)
    {
        $this->correctIdDiscipline($form);
        $model = $this->repository->getUser($id, $form->user_id);
        $model->data($form);
        $this->repository->save($model);
    }

    private function correctIdDiscipline(UserDisciplineCseForm $form) {
        $discipline = $this->dictDisciplineRepository->get($form->discipline_id);
        if($discipline->composite_discipline) {
            $discipline = $this->dictDisciplineRepository->get($form->discipline_select_id);
        }
        if ($form->type == UserDiscipline::CSE) {
            $this->cseSubjectRepository->get($discipline->cse_subject_id);
        }
        if ($form->type == UserDiscipline::CT) {
            $this->ctSubjectRepository->get($discipline->ct_subject_id);
        }
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }
}