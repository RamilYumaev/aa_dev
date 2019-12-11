<?php


namespace common\sending\repositories;


use common\sending\models\DictSendingTemplate;

class DictSendingTemplateRepository
{
    public function get($id): DictSendingTemplate
    {
        if (!$model = DictSendingTemplate::findOne($id)) {
            throw new \DomainException( 'DDictSendingTemplate не найдено.');
        }
        return $model;
    }

    public function save(DictSendingTemplate $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(DictSendingTemplate $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

}