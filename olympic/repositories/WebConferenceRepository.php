<?php

namespace olympic\repositories;
use olympic\models\WebConference;

class WebConferenceRepository
{

    public function get($id): WebConference
    {
        if (!$model = WebConference::findOne($id)) {
            throw new \DomainException('Вебинар не найден.');
        }
        return $model;
    }

    public function save(WebConference $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(WebConference $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

}