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
            $model = $model->typeClassAndOrderById([DictClassHelper::BACALAVR,
                DictClassHelper::BACALAVR_LAST,
                DictClassHelper::GRADUATED_BACALAVR,
                DictClassHelper::MAGISTR,
                DictClassHelper::MAGISTR_LAST,
                DictClassHelper::GRADUATED_SPECIALIST,
                DictClassHelper::SPECIALIST,
                DictClassHelper::SPECIALIST_LAST,
                DictClassHelper::GRADUATED_MAGISTR,
                DictClassHelper::GRADUATED_ASPIRANTURA,
                DictClassHelper::GRADUATED_DOCTORANTURA]);
        } elseif ($onlyHs == OlympicHelper::FOR_PUPLE) {
            $model = $model->typeClassAndOrderById([DictClassHelper::SCHOOL,
                DictClassHelper::SCHOOL_LAST,
                DictClassHelper::GRADUATED_SCHOOL,
                DictClassHelper::COLLEDGE, DictClassHelper::COLLEDGE_LAST,
                DictClassHelper::GRADUATED_COLLEGE]);
        } elseif ($onlyHs == OlympicHelper::FOR_STUDENT_PUPLE) {
            $model = $model->typeClassAndOrderById([
                DictClassHelper::SCHOOL,
                DictClassHelper::SCHOOL_LAST,
                DictClassHelper::GRADUATED_SCHOOL,
                DictClassHelper::COLLEDGE,
                DictClassHelper::COLLEDGE_LAST,
                DictClassHelper::GRADUATED_COLLEGE,
                DictClassHelper::BACALAVR_LAST,
                DictClassHelper::BACALAVR,
                DictClassHelper::GRADUATED_BACALAVR,
                DictClassHelper::MAGISTR,
                DictClassHelper::MAGISTR_LAST,
                DictClassHelper::SPECIALIST,
                DictClassHelper::SPECIALIST_LAST,
                DictClassHelper::GRADUATED_SPECIALIST,
                DictClassHelper::GRADUATED_MAGISTR,
                DictClassHelper::GRADUATED_ASPIRANTURA,
                DictClassHelper::GRADUATED_DOCTORANTURA]);

        } else {
            $model = $model->typeClassAndOrderById([DictClassHelper::MAGISTR, DictClassHelper::MAGISTR_LAST, DictClassHelper::GRADUATED_MAGISTR]);
        }
        $class = [];

        foreach ($model->all() as $classes) {
            $class[] = [
                'id' => $classes->id,
                'name' => ($classes->name ? $classes->name.'-й ': '') . DictClassHelper::typeName($classes->type),
            ];
        }
        return $class;
    }
}