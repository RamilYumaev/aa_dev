<?php

namespace operator\widgets\result\gird;

use olympic\helpers\auth\ProfileHelper;
use olympic\helpers\OlympicNominationHelper;
use olympic\helpers\PersonalPresenceAttemptHelper;
use yii\grid\DataColumn;
use yii\helpers\Html;
use Yii;


class PersonalReadUserAttemptColumn extends DataColumn
{
    protected function renderDataCellContent($model, $key, $index): string
    {
        return Html::tag('h4', $this->getProfile($model->user_id) .
            $this->getNameOfPlace($model->reward_status) .
            $this->getNomination($model->nomination_id));
    }

    private function getProfile($user_id): string
    {
        return ProfileHelper::profileFullName($user_id);
    }

    private function getNameOfPlace($reward_status): string
    {
        return $reward_status ? ' (' . PersonalPresenceAttemptHelper::nameOfPlacesOne($reward_status) . ') <br />' : " ";
    }

    private function getNomination($nomination_id): string
    {
        return $nomination_id ? "победитель в номинации: ".OlympicNominationHelper::olympicName($nomination_id) : " ";
    }
}
