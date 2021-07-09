<?php


use dictionary\helpers\DictRegionHelper;
use kartik\date\DatePicker;
use modules\dictionary\models\ScheduleVolunteering;
use yii\bootstrap\Modal;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use backend\widgets\adminlte\grid\GridView;
use dictionary\models\DictClass;
use modules\dictionary\models\DictSchedule;
use yii\jui\Dialog;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \modules\dictionary\searches\ScheduleVolunteeringSearch*/
/* @var $jobEntrant \modules\dictionary\models\JobEntrant */
\entrant\assets\modal\ModalAsset::register($this);
$this->title = 'Ваши графики работы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel'=> $searchModel,
                'columns' => [
                    ['class' => \yii\grid\SerialColumn::class],
                    ['attribute'=> 'date',
                        'value' => 'dictSchedule.date',
                        'format' => 'date',
                        'header' => 'Дата',
                        'filter' => DatePicker::widget([
                            'language' => 'ru',
                            'model' => $searchModel,
                            'attribute' => 'date',
                            'pluginOptions' => [
                                'todayHighlight' => true,
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd',
                            ],
                        ])
                    ],
                    ['attribute'=> 'category',
                        'header' => 'Центр',
                        'value' => 'dictSchedule.categoryName',
                        'filter' => \modules\dictionary\helpers\JobEntrantHelper::listVolunteeringCategories()
                   ],
                    [
                        'value' => function(ScheduleVolunteering $model)  {
                            return (!$model->reworkingVolunteering || $model->reworkingVolunteering->isStatusWatch() ?
                                Html::a('Переработка', ['schedule-volunteering/reworking', 'id' => $model->id],
                                    ['class' => 'btn btn-warning','data-pjax' => 'w4'.$model->id, 'data-toggle' => 'modal',
                        'data-target' => '#modal', 'data-modalTitle' => $model->dictSchedule->date.' '.$model->dictSchedule->categoryName]). " <br />" : "").
                                ($model->reworkingVolunteering ? 'Ваш статус: '.$model->reworkingVolunteering->statusName ." <br />" : '').
                                ($model->reworkingVolunteering || $model->reworkingVolunteering->isStatusReccall() ?Html::a('Причина отказа', ['#'],
                                    ['class' => 'btn btn-danger', 'data-confirm' => $model->dictSchedule->date.' '.$model->dictSchedule->categoryName.PHP_EOL.
                                        'Ваш статус: '.$model->reworkingVolunteering->statusName.PHP_EOL.
                                        'Причина отказа: '.$model->reworkingVolunteering->recall_text
                                    ]) : "");
                        },
                        'format' =>  'raw'
                    ],
                    ['class' => ActionColumn::class,
                        'controller' => "schedule-volunteering",
                        'template' => '{delete}',
                    ],
                ]
            ]); ?>
        </div>
    </div>
</div>
