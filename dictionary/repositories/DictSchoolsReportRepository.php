<?php
namespace dictionary\repositories;

use dictionary\helpers\DictCountryHelper;
use dictionary\models\DictSchoolsReport;


class DictSchoolsReportRepository
{
    public function get($id): DictSchoolsReport
    {
        if (!$model = DictSchoolsReport::findOne($id)) {
            throw new \DomainException('DictSchoolsReportReport не найдено.');
        }
        return $model;
    }

    public function isSchoolId($school_id)
    {
        if (DictSchoolsReport::findOne(['school_id' => $school_id])) {
            throw new \DomainException('Такая учебная оргнаизация существует.');
        }
    }

    public function save(DictSchoolsReport $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(DictSchoolsReport $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

}