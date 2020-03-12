<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $moderation common\moderation\models\Moderation*/

$this->title =  "Модерация. ". $moderation->getModel()->titleModeration();
$this->params['breadcrumbs'][] = ['label' => "Модерация", 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="moderation-view">
    <div class="box">
        <div class="box-body">
            <?= DetailView::widget(['model' => $moderation,
             // 'formatter' => ['class' => 'yii\i18n\Formatter','timeZone' => 'Europe/Moscow'],
             'attributes' => [
                      'model',
                      'record_id',
                      'message:html',    // description attribute in HTML
                 [ 'label' => $moderation->getAttributeLabel('created_by'),
                     'value' =>\olympic\helpers\auth\ProfileHelper::profileShortName($moderation->created_by)],
                 [ 'label' => $moderation->getAttributeLabel('status'),
                     'value' => \common\moderation\helpers\ModerationHelper::statusName($moderation->status)],
                 [ 'label' => $moderation->getAttributeLabel('moderated_by'),
                     'value' =>\olympic\helpers\auth\ProfileHelper::profileShortName($moderation->moderated_by)],
                  'created_at:datetime',
                  'updated_at:datetime',
                 ],]) ?>
        </div>
    </div>
    <div>
        <?= \common\moderation\widgets\ModerationWidget::widget(['moderation'=> $moderation]); ?>
    </div>
</div>
