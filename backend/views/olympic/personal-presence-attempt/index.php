<?php
use yii\helpers\Html;
use common\sending\helpers\SendingHelper;
use common\sending\helpers\SendingDeliveryStatusHelper;

/* @var $this \yii\web\View */
/* @var $olympic \olympic\models\OlimpicList */

$olympicAndYearName =  \olympic\helpers\OlympicListHelper::olympicAndYearName($olympic->id);
$this->title = $olympicAndYearName . '. Ведомость очного тура';
$this->params['breadcrumbs'][] = ['label' => 'Олимпиады/конкурсы', 'url' => ['olympic/olympic/index']];
$this->params['breadcrumbs'][] = ['label' => \olympic\helpers\OlympicHelper::olympicName($olympic->olimpic_id),
    'url' => ['olympic/olympic/view', 'id'=> $olympic->olimpic_id]];
$this->params['breadcrumbs'][] = ['label' => $olympicAndYearName,
    'url' => ['olympic/olimpic-list/view', 'id'=> $olympic->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <?php if(!$olympic->isResultEndTour()) :?>
       <?php if($olympic->isFormOfPassageDistantInternal()) :?>
           <?php if($olympic->year == \common\helpers\EduYearHelper::eduYear()) :?>
            <?= !SendingHelper::sendingData(SendingDeliveryStatusHelper::TYPE_OLYMPIC,
                SendingDeliveryStatusHelper::TYPE_SEND_INVITATION_AFTER_DISTANCE_TOUR, $olympic->id) ? Html::a("Запустить рассылку приглашений",
                ['olympic/olympic-delivery-status/send-invitation', 'olympic_id' => $olympic->id], ['class'=>'btn btn-info']) :
                Html::a("Просмотр статусов",
                    ['olympic/olympic-delivery-status/index', 'olympic_id' => $olympic->id,
                        'typeSending'=> SendingDeliveryStatusHelper::TYPE_SEND_INVITATION_AFTER_DISTANCE_TOUR], ['class'=>'btn btn-info'])?>
            <?php endif; ?>
           <?php endif; ?>
    <?= Html::a("Завершить и опубликовать результаты",
        ['olympic/personal-presence-attempt/finish', 'olympic_id' => $olympic->id], ['class'=>'btn btn-info'])?>
    <?= Html::a("Поставить/редактировать оценки присутствующим на очном туре",
        ['olympic/personal-presence-attempt/add-final-mark', 'olympic_id' => $olympic->id], ['class'=>'btn btn-danger'])?>
    <p>Для выставления оценок необходимо сначала подтвердить присутствие участников очного тура!</p>
    <?php \yii\widgets\Pjax::begin(['id' => 'my_pjax']) ?>
    <?= \backend\widgets\result\CountAttemptWidget::widget(['olympic' => $olympic->id]); ?>
    <?= \backend\widgets\result\ResultAttemptWidget::widget(['olympic' => $olympic]) ?>
    <?php \yii\widgets\Pjax::end(); ?>
    <?php else: ?>
        <?php if(!$olympic->isResultEndTour()) :?>
            <?php if($olympic->year == \common\helpers\EduYearHelper::eduYear()) :?>
        <?= !SendingHelper::sendingData(SendingDeliveryStatusHelper::TYPE_OLYMPIC,
            SendingDeliveryStatusHelper::TYPE_SEND_DIPLOMA, $olympic->id) ? Html::a("Запустить рассылку призеров олимпиады",
            ['olympic/olympic-delivery-status/send-diploma', 'olympic_id' => $olympic->id], ['class'=>'btn btn-info']) :
            Html::a("Просмотр статусов",
            ['olympic/olympic-delivery-status/index', 'olympic_id' => $olympic->id,
                'typeSending'=> SendingDeliveryStatusHelper::TYPE_SEND_DIPLOMA], ['class'=>'btn btn-info'])?>
            <?php endif; ?>
        <?php endif; ?>
        <?= \backend\widgets\result\CountAttemptWidget::widget(['olympic' => $olympic->id]); ?>
        <?= \backend\widgets\result\ResultAttemptWidget::widget(['olympic' => $olympic]) ?>

    <?php endif; ?>
</div>