<?php


use dictionary\helpers\DictRegionHelper;
use kartik\date\DatePicker;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use backend\widgets\adminlte\grid\GridView;
use dictionary\models\DictClass;
use modules\dictionary\models\DictSchedule;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \modules\dictionary\searches\DictScheduleSearch*/
/* @var $jobEntrant \modules\dictionary\models\JobEntrant */

$this->title = 'Выбор графика работы';
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
                        'value' => 'date',
                        'format' => 'date',
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
                    [ 'attribute' => 'count',
                        'value' => function(DictSchedule $model) {
                            return $model->getScheduleVolunteeringCount().' из '.$model->count;
                        },
                        ],
                    ['attribute'=> 'category',
                        'value' => 'categoryName',
                        'filter' => \modules\dictionary\helpers\JobEntrantHelper::listVolunteeringCategories()
                   ],
                    [
                        'value' => function(DictSchedule $model) use ($jobEntrant) {
                            return $model->isEntrant($jobEntrant->id)  || $model->isCountEnd() ? "" : Html::a('Взять график', ['dict-schedule/select-schedule', 'id' => $model->id], ['class' => 'btn btn-primary', 'data-confirm' => ['Вы уверены, что хотите взять график?']]);
                        },
                        'format' =>  'raw'
                    ],
                ]
            ]); ?>
        </div>
    </div>
</div>
