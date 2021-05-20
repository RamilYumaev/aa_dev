<?php

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\dictionary\models\SettingEntrant;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use backend\widgets\adminlte\grid\GridView;
use dictionary\models\DictClass;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $countAuto integer */
/* @var $searchModel modules\dictionary\searches\SettingCompetitionListSearch */

$this->title = 'Настройки конкурсных списоков';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <div class="box">
        <div class="box-header">
            <?= Html::a($countAuto ? 'Отменить АО': 'Возобновить', ['setting-entrant/auto', 'status' => $countAuto ? 0 : 1],
                ['class' => $countAuto ? 'btn btn-danger': 'btn btn-success', 'data'=> ['confirm'=> "Вы уверены, что хотите это сделать?"]])?>
        </div>
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel'=> $searchModel,
                'columns' => [
                    ['class' => \yii\grid\SerialColumn::class],
                    ['value' => function($model) {
                        /** @var \modules\dictionary\models\SettingCompetitionList $model */
                        return  Html::a('Настр. КП', ['setting-entrant/setting-competition-list','se'=>$model->se_id], ['class' => 'btn btn-primary']);
                    }, 'format' => 'raw'],
                    ['attribute'=>'is_auto', 'filter'=> ['Нет', 'Да'], 'value'=> 'is_auto', 'format' => 'boolean'],
                    ['attribute'=>'date_ignore', 'value'=>'dateIgnore'],
                    'date_start:date',
                    'time_start:time',
                    'date_end:date',
                    'time_end:time',
                    'end_date_zuk:datetime'
                ]
            ]); ?>
        </div>
    </div>
</div>
