<?php

use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Модерация';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="moderation">
    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
               // 'formatter' => ['class' => 'yii\i18n\Formatter','timeZone' => 'Europe/Moscow'],
                'rowOptions' => function( \common\moderation\models\Moderation $model){
                    if ($model->isStatusTake()) {
                        return ['class' => 'success'];
                    }else if ($model->isStatusReject()) {
                        return ['class' => 'danger'];
                    }
                },
                'columns' => [
                    ['class' => yii\grid\SerialColumn::class],
                    ['attribute' => 'model',
                        'value'=> function(\common\moderation\models\Moderation $model) {
                            return \common\moderation\helpers\ModerationHelper::modelOneName($model->model);
                        }],
                    ['attribute' => 'created_by',
                        'value'=> function(\common\moderation\models\Moderation $model) {
                            return\olympic\helpers\auth\ProfileHelper::profileShortName($model->created_by);
                        }],
                    ['attribute' => 'status',
                        'value'=> function(\common\moderation\models\Moderation $model) {
                            return \common\moderation\helpers\ModerationHelper::statusName($model->status);
                        }],
                    'record_id',
                    'created_at:datetime',
                    'updated_at:datetime',
                    ['class' => ActionColumn::class, 'template' => "{view}"],
                ]
            ]); ?>
        </div>
    </div>
</div>

