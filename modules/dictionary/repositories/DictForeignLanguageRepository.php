<?php


namespace modules\dictionary\repositories;
use modules\dictionary\models\DictForeignLanguage;

class DictForeignLanguageRepository
{
    public function get($id): DictForeignLanguage
    {
        if (!$model = DictForeignLanguage::findOne($id)) {
            throw new \DomainException('Язык не найден.');
        }
        return $model;
    }

    public function save(DictForeignLanguage $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(DictForeignLanguage $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

}