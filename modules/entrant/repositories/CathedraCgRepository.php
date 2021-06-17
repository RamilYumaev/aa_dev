<?php

namespace modules\entrant\repositories;
use dictionary\helpers\CathedraCgHelper;
use modules\dictionary\models\CathedraCg;
use modules\entrant\models\UserIndividualAchievements;
use modules\usecase\RepositoryDeleteSaveClass;

class CathedraCgRepository extends RepositoryDeleteSaveClass
{
    public function get($cg_id, $cathedra_id): CathedraCg
    {
        if (!$model =  CathedraCg::findOne(['cathedra_id'=> $cathedra_id, 'cg_id' => $cg_id])) {
            throw new \DomainException('Образовательная программа для аспирантуры не найдена.');
        }
        return $model;
    }

}