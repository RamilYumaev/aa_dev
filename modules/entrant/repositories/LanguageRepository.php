<?php


namespace modules\entrant\repositories;
use modules\entrant\models\Language;

class LanguageRepository
{
    public function get($id): Language
    {
        if (!$model = Language::findOne($id)) {
            throw new \DomainException('Язык не найден.');
        }
        return $model;
    }

    public function save(Language $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(Language $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

}