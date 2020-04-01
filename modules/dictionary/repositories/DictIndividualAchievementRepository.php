<?php


namespace modules\dictionary\repositories;
use modules\dictionary\models\DictIndividualAchievement;
use modules\usecase\RepositoryClass;

class DictIndividualAchievementRepository extends RepositoryClass
{
    public function __construct(DictIndividualAchievement $model)
    {
        $this->model = $model;
    }

}