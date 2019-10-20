<?php
namespace common\repositories\dictionary;
use common\models\dictionary\Faculty;


class FacultyRepository
{
    public function get($id): Faculty
    {
        if (!$faculty = Faculty::findOne($id)) {
            throw new NotFoundException('Faculty is not found.');
        }
        return $faculty;
    }

    public function save(Faculty $faculty): void
    {
        if (!$faculty->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Faculty $faculty): void
    {
        if (!$faculty->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }


}