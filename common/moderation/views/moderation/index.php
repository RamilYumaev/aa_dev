<?php

use modules\entrant\helpers\SelectDataHelper;
use modules\entrant\models\UserAis;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Модерация';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="moderation">
    <div class="box">
        <div class="box-body  table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel'=> $searchModel,
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
                        'filter' =>  SelectDataHelper::dataSearchModel($searchModel,   \common\moderation\helpers\ModerationHelper::modelList(),  'model', 'model'),
                        'value'=> function(\common\moderation\models\Moderation $model) {
                            return $model->getModel()->titleModeration();
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
                    ['attribute' => 'isIncoming',
                        'format'=>'raw',
                        'filter'=> ['Нет', "Да"],
                        'header'=> "Загружен в АИС ВУЗ",
                        'value'=> function($model) {
                         $ais = UserAis::findOne(['user_id' => $model->created_by]);
                        return $ais ?  Html::tag("span", "Загружен в АИС", ['class' => "label label-success"]) : Html::tag("span", "Не загружен в АИС", ['class' => "label label-danger"]);
            } ],

                    'created_at:datetime',
                    'updated_at:datetime',
                    ['class' => ActionColumn::class, 'template' => "{view}"],
                ]
            ]); ?>
        </div>
    </div>
</div>

