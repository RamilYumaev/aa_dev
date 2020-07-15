<?php

namespace backend\widgets\testing\gird;

use olympic\helpers\auth\ProfileHelper;
use olympic\helpers\OlympicListHelper;
use olympic\helpers\OlympicNominationHelper;
use olympic\models\OlimpicList;
use olympic\models\OlimpicNomination;
use testing\helpers\TestAttemptHelper;
use testing\models\Test;
use testing\models\TestAttempt;
use yii\grid\DataColumn;
use yii\helpers\Html;
use Yii;

class ButtonResultAnswerAttemptTestColumn extends DataColumn
{
    protected function renderDataCellContent($model, $key, $index): string
    {
        return  Html::tag('h4', $this->getProfile($model->user_id).
                 $this->getNameOfPlace($model->reward_status).
                 $this->getNomination($model->nomination_id)).
                 ($this->isStatusActiveOlympic($model) ? Html::tag('br').
                 $this->getRewardStatus($model): null);
    }

    private function getProfile($user_id): string
    {
        return ProfileHelper::profileFullName($user_id);
    }

    private function getNameOfPlace($reward_status): string
    {
        return $reward_status ? ' (' . TestAttemptHelper::nameOfPlacesOne($reward_status) . ') <br />' : " ";
    }

    private function getNomination($nomination_id): string
    {
        return $nomination_id ? "победитель в номинации: ".OlympicNominationHelper::olympicName($nomination_id) : " ";
    }

    private  function  getRewardStatus(TestAttempt  $model) {
            return($model->ballGold() ? $this->getButtonGold($model) : "").
                ($model->ballNoGold() ? $this->getButtonSilver($model).
                $this->getButtonBronze($model) :""). $this->getButtonMember($model, $this->getOlympic($model)).
                $this->getButtonRewardInNomination($model, $this->getOlympic($model)).

                $this->getButtonDeleteReward($model);
    }

    private  function  getButtonGold(TestAttempt  $model)
    {
        return $model->isBallInMark() ?
            $model->isRewardGold() ? Html::a('1-е место', '#', ['class' => 'btn btn-success', 'disabled' => 'disabled']) :
                Html::a('1-е место',['testing/test-attempt/gold', 'id' => $model->id], ['class' => 'btn btn-success']) . ' ' : '';
    }

    private  function  getButtonSilver(TestAttempt $model)
    {
        return  $model->isBallInMark() ? $model->isRewardSilver() ?
            Html::a('2-е место', '#',
                ['class' => 'btn btn-primary', 'disabled' => 'disabled']) :
            Html::a('2-е место',['testing/test-attempt/silver','id' => $model->id],
                ['class' => 'btn btn-primary']) . ' ' : '';
    }

    private  function  getButtonBronze(TestAttempt $model)
    {
        return $model->isBallInMark() ? $model->isRewardBronze() ?
            Html::a('3-е место', '#', ['class' => 'btn btn-warning', 'disabled' => 'disabled'])
            :  Html::a('3-е место', ['testing/test-attempt/bronze','id' => $model->id],
                ['class' => 'btn btn-warning']) . ' ' : '';
    }

    private  function  getButtonMember(TestAttempt $model, OlimpicList $olimpicList)
    {
        return $olimpicList->isTimeStartTour() && $model->isBallInMark() ?  $model->isRewardMember() ?
            Html::a('Участник следующего тура', '#', ['class' => 'btn btn-info', 'disabled' => 'disabled'])
            :  Html::a('Участник следующего тура', ['testing/test-attempt/member','id' => $model->id],
                ['class' => 'btn btn-info']) . ' ' : '';
    }


    private  function  getButtonRewardInNomination(TestAttempt  $model, OlimpicList $olimpicList)
    {
        $allNomination = OlimpicNomination::find()->andWhere(['olimpic_id' => $olimpicList->id ])->all();
        if (count($allNomination)) {
            $result = '<h4>или победитель в номинации:</h4>';
            foreach ($allNomination as $nomination) {
                if ($model->nomination_id == $nomination->id) {
                    $result .= Html::a($nomination->name, '#', ['class' => 'btn btn-default', 'disabled' => 'disabled']) . ' ';
                } elseif ($model->isBallInMark()) {
                    $result .= Html::a($nomination->name,  ['testing/test-attempt/nomination','id' => $model->id,
                            'nominationId' => $nomination->id], ['class' => 'btn btn-default']) . ' ';
                } else {
                    $result .= '';
                }
            }
            return $result;
        }
    }

    private function getButtonDeleteReward(TestAttempt $model) {
        if (!$model->isNullNomination() || !$model->isRewardStatusNull())
            return
                Html::a('удалить из лауреатов', ['testing/test-attempt/remove','id' => $model->id],
                    ['title' => Yii::t('yii', 'Delete'),
                        'class' => 'btn btn-danger',]
                );
    }

    private function getOlympic(TestAttempt $model) {
        $test = Test::findOne($model->test_id);
        return OlympicListHelper::olympicOne($test->olimpic_id);
    }

    private function isStatusActiveOlympic(TestAttempt $model) {
        return $this->getOlympic($model)->isRegStatus();
    }

}
