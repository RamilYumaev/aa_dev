<?php
namespace testing\repositories;

use testing\models\TestQuestion;

class TestQuestionRepository
{
    public function get($id): TestQuestion
    {
        if (!$model = TestQuestion::findOne($id)) {
            throw new \DomainException( 'TestQuestion не найдено.');
        }
        return $model;
    }

    public function getIdAndGroupId($id, $group_id): TestQuestion
    {
        if (!$model = TestQuestion::findOne(['id' => $id, 'group_id' => $group_id])) {
            throw new \DomainException( 'Данный вопрос не присутствует в группе вопросов.');
        }
        return $model;
    }

    public function save(TestQuestion $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(TestQuestion $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }


}