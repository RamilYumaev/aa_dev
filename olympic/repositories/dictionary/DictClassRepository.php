<?php
<<<<<<< HEAD:backend/repositories/dictionary/DictClassRepository.php

namespace backend\repositories\dictionary;
=======
namespace olympic\repositories\dictionary;
>>>>>>> #10:olympic/repositories/dictionary/DictClassRepository.php

use olympic\models\dictionary\DictClass;
use yii\web\NotFoundHttpException;

class DictClassRepository
{
    public function get($id): DictClass
    {
        if (!$model = DictClass::findOne($id)) {
            throw new NotFoundHttpException('DictClass не найдено.');
        }
        return $model;
    }

    public function save(DictClass $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(DictClass $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

}