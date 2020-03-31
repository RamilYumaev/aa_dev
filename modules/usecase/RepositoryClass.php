<?php


namespace modules\usecase;


use RuntimeException;
use yii\db\BaseActiveRecord;

class RepositoryClass
{
    public $model;
    public $getException = "Элемент не найден";
    public $saveException = "Ошибка при сохранении";
    public $removeException = "Ошибка при удалении";

    public function get($id): BaseActiveRecord
    {
        if (!$model = $this->model::findOne($id)) {
            throw new \DomainException($this->getException . " " . $id);
        }
        return $model;
    }

    public function save(BaseActiveRecord $model): void
    {
        if (!$model->save()) {
            throw new RuntimeException($this->saveException);
        }
    }

    /**
     * @param BaseActiveRecord $model
     * @throws \yii\db\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function remove(BaseActiveRecord $model): void
    {
        if (!$model->delete()) {
            throw new RuntimeException($this->removeException);
        }
    }

}