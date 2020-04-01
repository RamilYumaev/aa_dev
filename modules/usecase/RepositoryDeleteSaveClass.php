<?php


namespace modules\usecase;


use RuntimeException;
use yii\db\BaseActiveRecord;

class RepositoryDeleteSaveClass
{
    public $saveException = "Ошибка при сохранении";
    public $removeException = "Ошибка при удалении";

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