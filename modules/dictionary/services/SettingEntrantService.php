<?php


namespace modules\dictionary\services;

use modules\dictionary\models\SettingEntrant;
use modules\dictionary\repositories\SettingEntrantRepository;
use modules\usecase\ServicesClass;

class SettingEntrantService extends ServicesClass
{
    public function __construct(SettingEntrantRepository $repository, SettingEntrant $model)
    {
        $this->repository = $repository;
        $this->model = $model;
    }
}