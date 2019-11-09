<?php

namespace dictionary\repositories;

use dictionary\helpers\DictCountryHelper;
use dictionary\helpers\DictSchoolsHelper;
use dictionary\models\DictSchools;


class DictSchoolsRepository
{
    public function get($id): DictSchools
    {
        if (!$model = DictSchools::findOne($id)) {
            throw new \DomainException('DictSchools не найдено.');
        }
        return $model;
    }

    public function getFull($name, $country_id, $region_id)
    {
        $region = $country_id == DictCountryHelper::RUSSIA ? $region_id : null;
        if (DictSchools::findOne(['name' => $name, 'country_id'=> $country_id, 'region_id'=>  $region])) {
            throw new \DomainException('Такая учебная оргнаизация существует.');
        }
    }

    public function save(DictSchools $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(DictSchools $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

}