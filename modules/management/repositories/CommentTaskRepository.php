<?php

namespace modules\management\repositories;
use modules\management\models\CommentTask;

class CommentTaskRepository
{
    /**
     * @param CommentTask $model
     * @throws \Exception
     */
    public function save(CommentTask $model): void
    {
        if (!$model->save()) {
            throw new \Exception("Ошибка при сохранении");
        }
    }

    /**
     * @param CommentTask $model
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(CommentTask $model): void
    {
        if(!$model->delete())
        {
            throw new \Exception("Ошибка при удалении");
        }
    }

}