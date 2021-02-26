<?php

use modules\entrant\helpers\SelectDataHelper;
use modules\management\models\PostRateDepartment;
use modules\management\models\Schedule;
use backend\widgets\adminlte\grid\GridView;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel modules\management\searches\DateOffSearch */

$this->title = 'Отгулы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel'=> $searchModel,
                'tableOptions' => ['class' => 'table table-bordered app-table'],
                'columns' => [
                    ['class' => \yii\grid\SerialColumn::class],
                    ['attribute' => 'schedule_id',
                        'format' => "raw",
                        'filter' =>SelectDataHelper::dataSearchModel($searchModel, Schedule::find()->getAllColumnDateOff(),'schedule_id', 'schedule.profile.fio'),
                        'value' => function($model) {
                              return $model->schedule->profile->fio."<br />".$model->schedule->profile->phone."<br />".$model->schedule->email;
                        }],
                    'date:date',
                    [ 'attribute'=>'isAllowed',
                        'format' => 'raw',
                        'filter' => ['Нет', 'Да'],
                        'value' => function(\modules\management\models\DateOff $model) {
                              return  Html::a($model->isAllowed ? 'Отменить': 'Одобрить', ['allowed', 'id'=> $model->id,
                                  'is' => $model->isAllowed ? false: true], ['class'=> !$model->isAllowed ? 'btn btn-success' : 'btn btn-danger']);
                        }
                    ],
                ]
            ]); ?>
        </div>
    </div>
</div>
