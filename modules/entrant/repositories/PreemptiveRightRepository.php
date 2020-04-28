<?php
namespace modules\entrant\repositories;

use modules\entrant\models\PreemptiveRight;
use modules\usecase\RepositoryDeleteSaveClass;
use trntv\yii\datetime\assets\DateTimeAsset;

class PreemptiveRightRepository extends RepositoryDeleteSaveClass
{
    public function get($other_id, $type_id): PreemptiveRight
    {
        if (!$model = PreemptiveRight::findOne(['other_id'=> $other_id, 'type_id' => $type_id])) {
            throw new \DomainException('Прочий документ не найден.');
        }
        return $model;
    }

    public function isPreemptive($other_id, $type_id): void
    {
        if ($model = PreemptiveRight::findOne(['other_id'=> $other_id, 'type_id' => $type_id])) {
            throw new \DomainException('Такой документ для данной категории существует.');
        }
    }

}