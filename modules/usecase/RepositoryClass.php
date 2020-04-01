<?php


namespace modules\usecase;


use RuntimeException;
use yii\db\BaseActiveRecord;

class RepositoryClass extends RepositoryDeleteSaveClass
{
    public $model;
    public $getException = "Элемент не найден";

    public function get($id): BaseActiveRecord
    {
        if (!$model = $this->model::findOne($id)) {
            throw new \DomainException($this->getException . " " . $id);
        }
        return $model;
    }
}