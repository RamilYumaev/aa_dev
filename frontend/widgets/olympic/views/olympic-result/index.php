<?php
/* @var $olympic olympic\models\OlimpicList */
use yii\helpers\Html;
use olympic\helpers\OlympicHelper;
?>
<?php if ($olympic->isResultDistanceTour()  && $olympic->current_status == OlympicHelper::ZAOCH_FINISH) :?>
    <?= html::a('Результаты заочного (отборочного) тура',
            ['/print/olimp-result', 'olympic_id' => $olympic->id, 'numTour' => OlympicHelper::ZAOCH_FINISH]) ?> <br/>
<?php endif; ?>
<?php if ($olympic->isStatusAppeal() || $olympic->isStatusPreliminaryFinish()): ?>
    <?= Html::a('Предварительные результаты олимпиады',
        ['/print/olimp-result', 'olympic_id' => $olympic->id,
            'numTour' => $olympic->isFormOfPassageDistantInternal() ? OlympicHelper::OCH_FINISH : null]); ?><br/>
<?php endif; ?>
<?php if ($olympic->isResultEndTour()): ?>
    <?= Html::a('Результаты олимпиады',
            ['/print/olimp-result', 'olympic_id' => $olympic->id,
                'numTour' => $olympic->isFormOfPassageDistantInternal() ? OlympicHelper::OCH_FINISH : null]); ?><br/>
<?php endif; ?>

