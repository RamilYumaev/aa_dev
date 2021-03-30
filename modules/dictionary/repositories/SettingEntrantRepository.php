<?php

namespace modules\dictionary\repositories;


use modules\dictionary\models\SettingEntrant;
use modules\usecase\RepositoryDeleteSaveClass;

class SettingEntrantRepository extends RepositoryDeleteSaveClass
{
    public function get($id): SettingEntrant
    {
        if (!$model = SettingEntrant::findOne($id)) {
            throw new \DomainException("Данные не найдены");
        }
        return $model;
    }

}