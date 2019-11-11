<?php


namespace olympic\repositories;


use olympic\models\ClassAndOlympic;

class ClassAndOlympicRepository
{
    public function get($olympic_id, $class_id): ?ClassAndOlympic
    {
        if (!$model = ClassAndOlympic::findOne(['olympic_id' => $olympic_id, 'class_id' => $class_id])) {
            throw new \DomainException('Вы не можете принимать участие в этой олимпиаде, так как 
                    не соответствует класс/курс!');
        }
        return $model;
    }

}