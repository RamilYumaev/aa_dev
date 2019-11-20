<?php

namespace dictionary\services;

use dictionary\forms\OlimpiadsTypeTemplatesCreateForm;
use dictionary\forms\OlimpiadsTypeTemplatesEditForm;
use dictionary\models\OlimpiadsTypeTemplates;
use dictionary\repositories\DictSpecialTypeOlimpicRepository;
use dictionary\repositories\OlimpiadsTypeTemplatesRepository;
use dictionary\repositories\TemplatesRepository;

class OlimpiadsTypeTemplatesService
{
    private $repository;
    private $templatesRepository;
    private $specialTypeOlimpicRepository;

    public function __construct(OlimpiadsTypeTemplatesRepository $repository,
                                TemplatesRepository $templatesRepository,
                                DictSpecialTypeOlimpicRepository $specialTypeOlimpicRepository)
    {
        $this->repository = $repository;
        $this->templatesRepository = $templatesRepository;
        $this->specialTypeOlimpicRepository = $specialTypeOlimpicRepository;
    }

    public function create(OlimpiadsTypeTemplatesCreateForm $form)
    {
        $templates = $this->templatesRepository->get($form->template_id);
        $specialTypeOlimpic  = $this->isSpecialTypeOlimpic($form->special_type);
        $model = OlimpiadsTypeTemplates::create($form, $templates->id, $specialTypeOlimpic);

        $this->repository->save($model);
        return $model;
    }

    public function edit(OlimpiadsTypeTemplatesEditForm $form)
    {
        $templates = $this->templatesRepository->get($form->template_id);
        $specialTypeOlimpic =  $this->isSpecialTypeOlimpic($form->special_type);
        $model = $this->repository->get($form->_olimpiadsTypeTemplates->id);
        $model->edit($form, $templates->id, $specialTypeOlimpic);
        $this->repository->save($model);
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }

    private function isSpecialTypeOlimpic ($specialType) {
        if ($specialType) {
            $specialTypeOlimpic = $this->specialTypeOlimpicRepository->get($specialType);
        }
          return $specialTypeOlimpic->id ?? null;
    }
}