<?php


namespace olympic\repositories;


use common\helpers\EduYearHelper;
use olympic\models\ClassAndOlympic;
use olympic\models\OlimpicList;
use yii\web\HttpException;

class OlimpicListRepository
{

    public function getEduYear($id): OlimpicList
    {
        if (!$model = OlimpicList::findOne(['id' => $id, 'year' => EduYearHelper::eduYear() ])) {
            throw new \DomainException('Данная олимпиада не имеет запись на '.EduYearHelper::eduYear(). ' учебынй год!');
        }
        return $model;
    }

    public function get($id): OlimpicList
    {
        if (!$model = OlimpicList::findOne($id)) {
            throw new HttpException('403', "Нет такой олимпиады");
        }
        return $model;
    }

    public function save(OlimpicList $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(OlimpicList $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

}