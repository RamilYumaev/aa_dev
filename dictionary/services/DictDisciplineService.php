<?php


namespace dictionary\services;


use common\transactions\TransactionManager;
use dictionary\forms\DictDisciplineCreateForm;
use dictionary\forms\DictDisciplineEditForm;
use dictionary\models\CompositeDiscipline;
use dictionary\models\DictDiscipline;
use dictionary\repositories\DictDisciplineRepository;

class DictDisciplineService
{
    private $repository;
    private $transactionManager;

    public function __construct(DictDisciplineRepository $repository, TransactionManager $transactionManager)
    {
        $this->repository = $repository;
        $this->transactionManager = $transactionManager;
    }

    public function create(DictDisciplineCreateForm $form)
    {
        $this->transactionManager->wrap(function () use ($form) {
            $model = DictDiscipline::create($form);
            $this->repository->save($model);
            $this->saveCompositeDiscipline($form, $model->id);
        });
    }

    public function edit($id, DictDisciplineEditForm $form)
    {
        $model = $this->repository->get($id);
        $model->edit($form);
        $this->deleteRelation($id);
        $this->saveCompositeDiscipline($form, $id);
        $this->repository->save($model);
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->deleteRelation($model->id);
        $this->repository->remove($model);
    }

    private function saveCompositeDiscipline($form, $id) {
        if ($form->composite_discipline) {
            if(count($form->composite_disciplines) < 2) {
                throw new \DomainException("Количество составных дисциплин должно быть не меньше 2");
            }
            foreach ($form->composite_disciplines as $discipline) {
                CompositeDiscipline::create($id, $discipline)->save();
            }
        }
    }

    private function deleteRelation($disciplineId)
    {
        CompositeDiscipline::deleteAll(['discipline_id' => $disciplineId]);
    }
}