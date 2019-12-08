<?php

namespace backend\widgets\result\gird;

use yii\helpers\Url;
use olympic\models\PersonalPresenceAttempt;
use yii\grid\DataColumn;
use yii\helpers\Html;
use Yii;


class PersonalMarkReadAttemptColumn extends DataColumn
{
    protected function renderDataCellContent($model, $key, $index): string
    {
        return $this->getMarkAndAddMark($model);
    }

    private function getMarkAndAddMark(PersonalPresenceAttempt  $model) {
        if (!$model->isMarkNull())
            return Html::tag('h3', $model->mark);
        else return "Нет оценки";
    }
}