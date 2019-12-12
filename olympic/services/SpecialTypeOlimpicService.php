<?php


namespace olympic\services;

use dictionary\repositories\DictSpecialTypeOlimpicRepository;
use olympic\forms\SpecialTypeOlimpicCreateForm;
use olympic\forms\SpecialTypeOlimpicEditForm;
use olympic\models\SpecialTypeOlimpic;
use olympic\repositories\OlimpicListRepository;
use olympic\repositories\SpecialTypeOlimpicRepository;

class SpecialTypeOlimpicService
{
    private $repository;
    private $olimpicListRepository;
    private $specialTypeOlimpicRepository;

    public function __construct(SpecialTypeOlimpicRepository $repository,
                                OlimpicListRepository $olimpicListRepository, DictSpecialTypeOlimpicRepository $specialTypeOlimpicRepository)
    {
        $this->repository = $repository;
        $this->specialTypeOlimpicRepository = $specialTypeOlimpicRepository;
        $this->olimpicListRepository = $olimpicListRepository;
    }

    public function create(SpecialTypeOlimpicCreateForm $form)
    {
        $specialTypeOlimpic = $this->specialTypeOlimpicRepository->get($form->special_type_id);
        $olympic = $this->olimpicListRepository->get($form->olimpic_id);
        $model = SpecialTypeOlimpic::create($olympic->id, $specialTypeOlimpic->id);
        $this->repository->save($model);
        return $model;
    }

    public function edit(SpecialTypeOlimpicEditForm $form)
    {
        $model = $this->repository->get($form->_specialTypeOlimpic->id);
        $specialTypeOlimpic = $this->specialTypeOlimpicRepository->get($form->special_type_id);
        $olympic = $this->olimpicListRepository->get($form->olimpic_id);
        $model->edit($olympic->id,  $specialTypeOlimpic->id);
        $this->repository->save($model);
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }
}