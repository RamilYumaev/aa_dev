<?php
/* @var $olympic olympic\models\OlimpicList */
use yii\helpers\Html;
use olympic\helpers\OlympicHelper;
?>
<?php if ($olympic->isResultDistanceTour()) :?>
    <?= html::a('Результаты заочного (отборочного) тура',
            ['/print/olimp-result', 'olympic_id' => $olympic->id, 'numTour' => OlympicHelper::ZAOCH_FINISH]) ?> <br/>
<?php elseif ($olympic->isResultEndTour()): ?>
    <?= Html::a('Результаты олимпиады',
            ['/print/olimp-result', 'olympic_id' => $olympic->id,
                'numTour' => $olympic->isFormOfPassageDistantInternal() ? OlympicHelper::OCH_FINISH : null]); ?><br/>
<?php endif; ?>

