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
        $specialTypeOlimpic = $this->specialTypeOlimpicRepository->get($form->special_type);
        $model = OlimpiadsTypeTemplates::create($form, $templates->id, $specialTypeOlimpic->id);

        $this->repository->save($model);
        return $model;
    }

    public function edit(OlimpiadsTypeTemplatesEditForm $form, $number_of_tours, $form_of_passage, $edu_level_olimp, $template_id)
    {
        $templates = $this->templatesRepository->get($form->template_id);
        $specialTypeOlimpic = $this->specialTypeOlimpicRepository->get($form->special_type);
        $model = $this->repository->get($number_of_tours, $form_of_passage, $edu_level_olimp, $template_id);
        $model->edit($form, $templates->id, $specialTypeOlimpic->id);
        $this->repository->save($model);
    }

    public function remove($number_of_tours, $form_of_passage, $edu_level_olimp, $template_id)
    {
        $model = $this->repository->get($number_of_tours, $form_of_passage, $edu_level_olimp, $template_id);
        $this->repository->remove($model);
    }
}