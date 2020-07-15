<?php


namespace modules\dictionary\services;

use common\transactions\TransactionManager;
use dictionary\models\DictDiscipline;
use modules\dictionary\models\DictExaminer;
use modules\dictionary\models\ExaminerDiscipline;
use modules\dictionary\repositories\DictExaminerRepository;
use modules\dictionary\repositories\ExaminerDisciplineRepository;
use modules\usecase\ServicesClass;
use yii\base\Model;


class DictExaminerService extends ServicesClass
{
    public $transactionManager, $examinerDisciplineRepository;

    public function __construct(DictExaminerRepository $repository, DictExaminer $model,
                                TransactionManager $transactionManager, ExaminerDisciplineRepository $examinerDisciplineRepository)
    {
        $this->repository = $repository;
        $this->model = $model;
        $this->transactionManager = $transactionManager;
        $this->examinerDisciplineRepository = $examinerDisciplineRepository;
    }

    public function create(Model $form)
    {
        $this->transactionManager->wrap(function () use ($form) {
            $model = parent::create($form);
            foreach ($form->disciplineList as  $discipline) {
                $examDiscipline = ExaminerDiscipline::create($model->id, $discipline);
                $this->examinerDisciplineRepository->save($examDiscipline);
            }
        });
    }

    public function edit($id, Model $form)
    {
        $this->transactionManager->wrap(function () use ($form, $id) {
            parent::edit($id, $form);
            ExaminerDiscipline::deleteAll(['examiner_id' => $id]);
            foreach ($form->disciplineList as  $discipline) {
                $examDiscipline = ExaminerDiscipline::create($id, $discipline);
                $this->examinerDisciplineRepository->save($examDiscipline);
            }
         });
    }

}