<?php


namespace modules\dictionary\services;

use modules\dictionary\models\SettingCompetitionList;
use modules\dictionary\repositories\SettingCompetitionListRepository;
use modules\usecase\ServicesClass;

class SettingCompetitionListService extends ServicesClass
{
    public function __construct(SettingCompetitionListRepository $repository, SettingCompetitionList $model)
    {
        $this->repository = $repository;
        $this->model = $model;
    }
}