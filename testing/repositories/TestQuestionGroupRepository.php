<?php
namespace testing\repositories;

use testing\models\TestQuestionGroup;

class TestQuestionGroupRepository
{
    public function get($id): TestQuestionGroup
    {
        if (!$model = TestQuestionGroup::findOne($id)) {
            throw new \DomainException( 'TestQuestionGroup не найдено.');
        }
        return $model;
    }

    public function getIs($id): ? TestQuestionGroup
    {
        return $model = TestQuestionGroup::findOne($id);
    }

    public function getIdAndOlympic($id, $olympic_id): TestQuestionGroup
    {
        if (!$model = TestQuestionGroup::findOne(['id' => $id, 'olimpic_id' => $olympic_id])) {
            throw new \DomainException( 'TestQuestionGroup не найдено.');
        }
        return $model;
    }

    public function save(TestQuestionGroup $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(TestQuestionGroup $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }


}