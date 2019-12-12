<?php

namespace operator\widgets\result\gird;

use yii\helpers\Url;
use olympic\models\PersonalPresenceAttempt;
use yii\grid\DataColumn;
use yii\helpers\Html;
use Yii;


class PersonalMarkAttemptColumn extends DataColumn
{
    protected function renderDataCellContent($model, $key, $index): string
    {
        return $this->getMarkAndAddMark($model);
    }

    private function getMarkAndAddMark(PersonalPresenceAttempt  $model) {
        if (!$model->isMarkNull())
            return Html::tag('h3', $model->mark).' ' . Html::a('Удалить', ['olympic/personal-presence-attempt/delete-final-mark', 'id' => $model->id],
                             ['data-pjax' => '#my_pjax',
                             'class'=> 'btn btn-danger',
                             'title' => Yii::t('yii', 'Delete')]);
        else return "Нет оценки";
    }
}