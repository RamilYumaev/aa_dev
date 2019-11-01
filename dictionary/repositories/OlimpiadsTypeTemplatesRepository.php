<?php


namespace dictionary\repositories;


use dictionary\models\OlimpiadsTypeTemplates;

class OlimpiadsTypeTemplatesRepository
{
    public function get($number_of_tours, $form_of_passage, $edu_level_olimp, $template_id): OlimpiadsTypeTemplates
    {
        if (!$model = OlimpiadsTypeTemplates::findOne(['number_of_tours'=>$number_of_tours,
            'form_of_passage'=>$form_of_passage, 'edu_level_olimp'=>$edu_level_olimp, 'template_id'=> $template_id])) {
            throw new \DomainException('OlimpiadsTypeTemplates не найдено.');
        }
        return $model;
    }

    public function save(OlimpiadsTypeTemplates $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(OlimpiadsTypeTemplates $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }


}