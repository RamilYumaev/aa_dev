<?php

use yii\helpers\Html;
use common\sending\helpers\SendingHelper;
use common\sending\helpers\SendingDeliveryStatusHelper;
use \testing\helpers\TestAttemptHelper;

/* @var $test testing\models\Test */
/* @var $olympic olympic\models\OlimpicList */
$this->title = "Попытки";
$this->params['breadcrumbs'][] = ['label' => \olympic\helpers\OlympicListHelper::olympicAndYearName($olympic->id),
    'url' => ['/olympic/olimpic-list/view', 'id' => $olympic->id]];
$this->params['breadcrumbs'][] = ['label' => "Tecт",
    'url' => ['/testing/test/view', 'id' => $test->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if ($olympic->isFormOfPassageDistant() || $olympic->isFormOfPassageDistantDistant()): ?>
    <?php if ($olympic->isDistanceFinish()): ?>
        <?php if ($olympic->year == \common\helpers\EduYearHelper::eduYear()) : ?>
            <?= !SendingHelper::sendingData(SendingDeliveryStatusHelper::TYPE_OLYMPIC,
                SendingDeliveryStatusHelper::TYPE_SEND_DIPLOMA, $olympic->id) ? Html::a("Запустить рассылку писем с дипломами",
                ['olympic/olympic-delivery-status/send-diploma', 'olympic_id' => $olympic->id], ['class' => 'btn btn-info']) :
                Html::a("Просмотр состояния рассылки (дипломы/сертификаты)",
                    ['olympic/olympic-delivery-status/index', 'olympic_id' => $olympic->id,
                        'typeSending' => SendingDeliveryStatusHelper::TYPE_SEND_DIPLOMA], ['class' => 'btn btn-info']) ?>
        <?php endif; ?>
    <?php else: ?>
        <?= Html::a("Завершить заочный тур", ['end-dist-tour', 'test_id' => $test->id, 'olympic_id' => $olympic->id], ['class' => 'btn btn-danger']) ?>
    <?php endif; ?>
<?php endif; ?>

<?php
if (\Yii::$app->user->can("dev") && TestAttemptHelper::checkOldDateAttempt($olympic->date_time_finish_reg, $test->id)): ?>
    <?= Html::a("Обновить даты окончания попыток", ["update-attempt", "testId"=>$test->id], ['class' => "btn btn-success"]) ?>
<?php endif; ?>
<?=Html::a("Подсчитать оценки незавершенных попыток", ['update-test-result', 'testId'=>$test->id], ['class'=>'btn btn-warning'])?>

<div class="row">
    <div class="col-md-12"><?= \backend\widgets\testing\TestAttemptWidget::widget(['test_id' => $test->id, 'olympicId' => $olympic->olimpic_id ]) ?></div>
</div>