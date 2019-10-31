<?php

namespace dictionary\services;

use dictionary\forms\DictClassEditForm;
use dictionary\forms\DictClassCreateForm;
use dictionary\helpers\DictClassHelper;
use dictionary\models\DictClass;
use dictionary\repositories\DictClassRepository;
use olympic\helpers\OlympicHelper;

class DictClassService
{
    private $repository;

    public function __construct(DictClassRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(DictClassCreateForm $form)
    {
        $model = DictClass::create($form);
        $this->repository->save($model);
    }

    public function edit($id, DictClassEditForm $form)
    {
        $model = $this->repository->get($id);
        $model->edit($form);
        $this->repository->save($model);
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }

    public function allClassesAjax($onlyHs) {

        $model = DictClass::find();
        if ($onlyHs == OlympicHelper::FOR_STUDENT) {
            $model = $model->typeClassAndOrderById([DictClassHelper::BACALAVR, DictClassHelper::MAGISTR]);
        } elseif ($onlyHs == OlympicHelper::FOR_PUPLE) {
            $model = $model->typeClassAndOrderById([DictClassHelper::SCHOOL, DictClassHelper::COLLEDGE]);
        } else {
            $model = $model->typeClassAndOrderById([DictClassHelper::MAGISTR]);
        }
        $class = [];

        foreach ($model->all() as $classes) {
            $class[] = [
                'id' => $classes->id,
                'name' => $classes->name . '-й ' . DictClassHelper::typeName($classes->type),
            ];
        }
        return $class;
    }
}