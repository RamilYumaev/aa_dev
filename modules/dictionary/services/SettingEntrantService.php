<?php


namespace modules\dictionary\services;

use modules\dictionary\forms\SettingCompetitionListForm;
use modules\dictionary\models\SettingCompetitionList;
use modules\dictionary\models\SettingEntrant;
use modules\dictionary\repositories\SettingCompetitionListRepository;
use modules\dictionary\repositories\SettingEntrantRepository;
use modules\usecase\ServicesClass;

class SettingEntrantService extends ServicesClass
{
    private $competitionListRepository;
    public function __construct(SettingEntrantRepository $repository, SettingCompetitionListRepository $competitionListRepository,SettingEntrant $model)
    {
        $this->competitionListRepository = $competitionListRepository;
        $this->repository = $repository;
        $this->model = $model;
    }

    public function createOrEditSCL(SettingCompetitionListForm $form)
    {
        if($model = SettingCompetitionList::findOne($form->se_id) ){
            $model->data($form);
        }else {
            $model = SettingCompetitionList::create($form);
        }
        $this->competitionListRepository->save($model);
    }
}