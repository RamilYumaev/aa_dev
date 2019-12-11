<?php


namespace common\sending\repositories;


use common\sending\models\Sending;

class SendingRepository
{
    public function get($id): Sending
    {
        if (!$model = Sending::findOne($id)) {
            throw new \DomainException( 'DSending не найдено.');
        }
        return $model;
    }

    public function save(Sending $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(Sending $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }


}