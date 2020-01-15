<?php

namespace dictionary\services;

use dictionary\forms\FacultyCreateForm;
use dictionary\forms\FacultyEditForm;
use dictionary\repositories\FacultyRepository;
use dictionary\models\Faculty;
use olympic\models\Moderation;
use yii\helpers\Json;


class FacultyService
{
    private $repository;

    public function __construct(FacultyRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(FacultyCreateForm $form)
    {
        $model = Faculty::create($form);
        $this->repository->save($model);
        return $model;
    }

    public function edit(FacultyEditForm $form)
    {
        $model = $this->repository->get($form->_faculty->id);
        $model->edit($form);
//        $moderation = new Moderation(['model'=> Faculty::class, 'record_id' => $model->id,
//            'before' => Json::encode($form->_faculty), 'after' => Json::encode($model)]);
//        $moderation->save();
        $this->repository->save($model);
    }

    public function editModeration(FacultyEditForm $form)
    {
        $model = $this->repository->get($form->_faculty->id);
        $model->edit($form);
        $moderation = Moderation::findOne(['record_id' => $model->id,]);
        $moderation->delete();
        $this->repository->save($model);
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }
}