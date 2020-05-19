<?php
namespace common\moderation\repositories;

use yii\db\BaseActiveRecord;

class BaseRepository
{
    public function get($id, BaseActiveRecord $baseModel): BaseActiveRecord
    {
        if (!$model = $baseModel::findOne($id)) {
            throw new \DomainException( 'Model не найдено.');
        }
        return $model;
    }

    public function save(BaseActiveRecord $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(BaseActiveRecord $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }



}