<?php
use yii\helpers\Html;
use common\sending\helpers\SendingHelper;
use common\sending\helpers\SendingDeliveryStatusHelper;
use olympic\helpers\OlympicHelper;

/* @var $this \yii\web\View */
/* @var $olympic \olympic\models\OlimpicList */

$olympicAndYearName =  \olympic\helpers\OlympicListHelper::olympicAndYearName($olympic->id);
$this->title = $olympicAndYearName . '. Ведомость очного тура'.($olympic->isStatusAppeal() ? '. Показ работы' : '');
$this->params['breadcrumbs'][] = ['label' => 'Олимпиады/конкурсы', 'url' => ['olympic/olympic/index']];
$this->params['breadcrumbs'][] = ['label' => \olympic\helpers\OlympicHelper::olympicName($olympic->olimpic_id),
    'url' => ['olympic/olympic/view', 'id'=> $olympic->olimpic_id]];
$this->params['breadcrumbs'][] = ['label' => $olympicAndYearName,
    'url' => ['olympic/olimpic-list/view', 'id'=> $olympic->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <?php if($olympic->isFormOfPassageDistantInternal() && !$olympic->isResultEndTour()) :?>
        <?php if($olympic->year == \common\helpers\EduYearHelper::eduYear()) :?>
            <?= !SendingHelper::sendingData(SendingDeliveryStatusHelper::TYPE_OLYMPIC,
                SendingDeliveryStatusHelper::TYPE_SEND_INVITATION_AFTER_DISTANCE_TOUR, $olympic->id) ? Html::a("Запустить рассылку приглашений",
                ['olympic/olympic-delivery-status/send-invitation', 'olympic_id' => $olympic->id], ['class'=>'btn btn-info']) :
                Html::a("Просмотр состояния рассылки (приглашения)",
                    ['olympic/olympic-delivery-status/index', 'olympic_id' => $olympic->id,
                        'typeSending'=> SendingDeliveryStatusHelper::TYPE_SEND_INVITATION_AFTER_DISTANCE_TOUR], ['class'=>'btn btn-info'])?>
            <?php endif; ?>
       <?php endif; ?>
    <?php if($olympic->isStatusAppeal() || (($olympic->isRegStatus()) && !$olympic->isAppeal())) :?>
    <?= Html::a("Завершить и опубликовать результаты",
        ['olympic/personal-presence-attempt/finish', 'olympic_id' => $olympic->id, 'status' => OlympicHelper::OCH_FINISH], ['class'=>'btn btn-info'])?>
        <?= Html::a("Поставить/редактировать оценки присутствующим на очном туре",
            ['olympic/personal-presence-attempt/add-final-mark', 'olympic_id' => $olympic->id], ['class'=>'btn btn-danger'])?>
        <p>Для выставления оценок необходимо сначала подтвердить присутствие участников очного тура!</p>
    <?php elseif($olympic->isStatusPreliminaryFinish()): ?>
        <?= Html::a("Показ работ",
        ['olympic/personal-presence-attempt/appeal', 'olympic_id' => $olympic->id],['class'=>'btn btn-warning'])?>
        <?php if($olympic->year == \common\helpers\EduYearHelper::eduYear()) :?>
            <?= !SendingHelper::sendingData(SendingDeliveryStatusHelper::TYPE_OLYMPIC,
                SendingDeliveryStatusHelper::TYPE_SEND_PRELIMINARY, $olympic->id) ? Html::a("Запустить рассылку писем с предварительными итогами",
                ['olympic/olympic-delivery-status/send-preliminary-result', 'olympic_id' => $olympic->id], ['class'=>'btn btn-info']) :
                Html::a("Просмотр состояния рассылки (предварительные итоги)",
                    ['olympic/olympic-delivery-status/index', 'olympic_id' => $olympic->id,
                        'typeSending'=> SendingDeliveryStatusHelper::TYPE_SEND_PRELIMINARY], ['class'=>'btn btn-info'])?>
        <?php endif; ?>
    <?php elseif($olympic->isResultEndTour()): ?>
        <?php if($olympic->year == \common\helpers\EduYearHelper::eduYear()) :?>
        <?= !SendingHelper::sendingData(SendingDeliveryStatusHelper::TYPE_OLYMPIC,
        SendingDeliveryStatusHelper::TYPE_SEND_DIPLOMA, $olympic->id) ? Html::a("Запустить рассылку писем с дипломами",
        ['olympic/olympic-delivery-status/send-diploma', 'olympic_id' => $olympic->id], ['class'=>'btn btn-info']) :
        Html::a("Просмотр состояния рассылки (дипломы/сертификаты)",
            ['olympic/olympic-delivery-status/index', 'olympic_id' => $olympic->id,
                'typeSending'=> SendingDeliveryStatusHelper::TYPE_SEND_DIPLOMA], ['class'=>'btn btn-info'])?>
        <?php endif; ?>
    <?php else: ?>
    <?= Html::a("Опубликовать предварительные результаты",
    ['olympic/personal-presence-attempt/finish', 'olympic_id' => $olympic->id, 'status' => OlympicHelper::PRELIMINARY_FINISH], ['class'=>'btn btn-info'])?>
        <?= Html::a("Поставить/редактировать оценки присутствующим на очном туре",
            ['olympic/personal-presence-attempt/add-final-mark', 'olympic_id' => $olympic->id], ['class'=>'btn btn-danger'])?>
        <p>Для выставления оценок необходимо сначала подтвердить присутствие участников очного тура!</p>
    <?php endif; ?>
    <?php \yii\widgets\Pjax::begin(['id' => 'my_pjax']) ?>
    <?= \backend\widgets\result\CountAttemptWidget::widget(['olympic' => $olympic->id]); ?>
    <?= \backend\widgets\result\ResultAttemptWidget::widget(['olympic' => $olympic]) ?>
    <?php \yii\widgets\Pjax::end(); ?>
</div>