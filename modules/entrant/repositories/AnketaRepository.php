<?php


namespace modules\entrant\repositories;


use modules\entrant\models\Anketa;

class AnketaRepository
{
    public function get($id)
    {
        if (!$model = Anketa::findOne($id)) {
            throw new \DomainException("Анкета не найдена");
        }
        return $model;
    }

    public static function save(Anketa $model)
    {
        if (!$model->save()) {
            throw new \DomainException("Ошибка при сохранении анкеты");
        }
    }

    public static function remove(Anketa $model)
    {
        if (!$model->delete()) {
            throw new \DomainException("Ошибка при удалении анкеты");
        }
    }

}