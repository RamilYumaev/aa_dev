<?php
namespace common\repositories\dictionary;
use common\models\dictionary\Faculty;


class FacultyRepository
{
    public function get($id): Faculty
    {
        if (!$faculty = Faculty::findOne($id)) {
            throw new NotFoundException('Faculty не найдено.');
        }
        return $faculty;
    }

    public function save(Faculty $faculty): void
    {
        if (!$faculty->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(Faculty $faculty): void
    {
        if (!$faculty->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }


}