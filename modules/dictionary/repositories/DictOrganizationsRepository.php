<?php


namespace modules\dictionary\repositories;


use modules\dictionary\models\DictOrganizations;
use modules\usecase\RepositoryClass;
use yii\db\StaleObjectException;

class DictOrganizationsRepository extends RepositoryClass
{
    public function __construct(DictOrganizations $model)
    {
        $this->model = $model;
    }

}