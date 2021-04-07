<?php

namespace modules\dictionary\repositories;


use modules\dictionary\models\SettingCompetitionList;
use modules\usecase\RepositoryDeleteSaveClass;

class SettingCompetitionListRepository extends RepositoryDeleteSaveClass
{
    public function get($id): SettingCompetitionList
    {
        if (!$model = SettingCompetitionList::findOne($id)) {
            throw new \DomainException("Данные не найдены");
        }
        return $model;
    }

}