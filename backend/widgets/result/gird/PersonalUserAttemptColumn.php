<?php

namespace backend\widgets\result\gird;

use olympic\models\OlimpicNomination;
use yii\helpers\Url;
use olympic\helpers\auth\ProfileHelper;
use olympic\helpers\OlympicNominationHelper;
use olympic\helpers\PersonalPresenceAttemptHelper;
use olympic\models\PersonalPresenceAttempt;
use yii\grid\DataColumn;
use yii\helpers\Html;
use Yii;


class PersonalUserAttemptColumn extends DataColumn
{
    protected function renderDataCellContent($model, $key, $index): string
    {
        return  Html::tag('h4', $this->getProfile($model->user_id).
            $this->getNameOfPlace($model->reward_status).
            $this->getNomination($model->nomination_id)).
            Html::tag('br').
            $this->getStatuses($model).
            Html::tag('br').
            $this->getRewardStatus($model);
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

    private function getStatuses(PersonalPresenceAttempt $model)
    {
        if ($model->isPresenceStatusNull()) {
            return $this->getButtonPresenceStatusIsNull($model);
        } else {
           return $this->getButtonPresenceStatus($model);
        }
    }

    private function getButtonPresenceStatusIsNull(PersonalPresenceAttempt  $model) {
        $isPresence = Html::a('Подтвердить присутствие', ['olympic/personal-presence-attempt/presence-status', 'id' => $model->id],
            [ 'class' => 'btn btn-info']);

        $isNoPresence = Html::a('Поставить неявку', ['olympic/personal-presence-attempt/no-presence-status', 'id' => $model->id],
            ['class' => 'btn btn-info']);
        return $isPresence ." ". $isNoPresence;
    }

    private function getButtonPresenceStatus(PersonalPresenceAttempt $model)
    {
           if($model->isNonAppearance()) {
           return 'Отсутствовал(а) на очном туре<br/>' .
               Html::a('Отменить подтверждение/неявку',  ['olympic/personal-presence-attempt/null-presence-status', 'id' => $model->id],
                   ['class' => 'btn btn-info']);
           } else {
               return 'Присутствовал(а) на очном туре<br/>' .
                   Html::a('Отменить подтверждение/неявку', ['olympic/personal-presence-attempt/null-presence-status', 'id' => $model->id],
                       ['class' => 'btn btn-info']) . '<br/>';
           }
    }

    private  function  getRewardStatus(PersonalPresenceAttempt  $model) {
        if ($model->isPresence() && !$model->isMarkNull()) {
            return ($model->ballFirstPlace() ? $this->getButtonRewardFirstPlace($model) :"").
                ($model->ballNoFirstPlace() ? $this->getButtonRewardSecondPlace($model). $this->getButtonRewardThirdPlace($model) :"").
                $this->getButtonRewardInNomination($model).
                $this->getButtonDeleteReward($model);
        }
    }

    private  function  getButtonRewardFirstPlace(PersonalPresenceAttempt  $model)
    {
        return $model->isBallInMark() ?
            $model->isRewardFirstPlace() ? Html::a('1-е место', '#', ['class' => 'btn btn-success', 'disabled' => 'disabled']) :
                Html::a('1-е место',['olympic/personal-presence-attempt/first-place', 'id' => $model->id], ['class' => 'btn btn-success']) . ' ' : '';
    }

    private  function  getButtonRewardSecondPlace(PersonalPresenceAttempt  $model)
    {
        return  $model->isBallInMark() ? $model->isRewardSecondPlace() ?
            Html::a('2-е место', '#',
                ['class' => 'btn btn-primary', 'disabled' => 'disabled']) :
            Html::a('2-е место',['olympic/personal-presence-attempt/second-place','id' => $model->id],
                    ['class' => 'btn btn-primary']) . ' ' : '';
    }

    private  function  getButtonRewardThirdPlace(PersonalPresenceAttempt  $model)
    {
        return $model->isBallInMark() ? $model->isRewardThirdPlace() ?
            Html::a('3-е место', '#', ['class' => 'btn btn-warning', 'disabled' => 'disabled'])
            :  Html::a('3-е место', ['olympic/personal-presence-attempt/third-place','id' => $model->id],
                ['class' => 'btn btn-warning']) . ' ' : '';
    }

    private  function  getButtonRewardInNomination(PersonalPresenceAttempt  $model)
    {
        $allNomination = OlimpicNomination::find()->andWhere(['olimpic_id' => $model->olimpic_id])->all();
        if (count($allNomination)) {
            $result = '<h4>или победитель в номинации:</h4>';
            foreach ($allNomination as $nomination) {
                if ($model->nomination_id == $nomination->id) {
                    $result .= Html::a($nomination->name, '#', ['class' => 'btn btn-default', 'disabled' => 'disabled']) . ' ';
                } elseif ($model->isBallInMark()) {
                    $result .= Html::a($nomination->name,  ['olympic/personal-presence-attempt/nomination','id' => $model->id,
                        'nominationId' => $nomination->id], ['class' => 'btn btn-default']) . ' ';
                } else {
                    $result .= '';
                }
            }
            return $result;
        }
    }

    private function getButtonDeleteReward(PersonalPresenceAttempt  $model) {
        if (!$model->isNullNomination()||!$model->isRewardStatusNull())
        return
            Html::a('удалить из лауреатов', ['olympic/personal-presence-attempt/remove-place','id' => $model->id],
                ['title' => Yii::t('yii', 'Delete'),
                    'class' => 'btn btn-danger',]
            );
    }
}