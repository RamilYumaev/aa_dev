<?php

namespace dictionary\repositories;

use dictionary\models\Faculty;
use yii\web\NotFoundHttpException;


class FacultyRepository
{
    public function get($id): Faculty
    {
        if (!$model = Faculty::findOne($id)) {
            throw new \DomainException( 'Факультет/Институт не найден.');
        }
        return $model;
    }

    public function save(Faculty $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(Faculty $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }


}