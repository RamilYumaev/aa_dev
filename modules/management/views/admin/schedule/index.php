<?php

use modules\entrant\helpers\SelectDataHelper;
use modules\management\models\PostRateDepartment;
use modules\management\models\Schedule;
use backend\widgets\adminlte\grid\GridView;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel modules\management\searches\ScheduleSearch */

$this->title = 'Графики';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <div class="box table-responsive">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel'=> $searchModel,
                'tableOptions' => ['class' => 'table table-bordered app-table'],
                'columns' => [
                    ['class' => \yii\grid\ActionColumn::class,
                        'controller'=>'schedule',
                        'template' => '{view}'],
                    ['class' => \yii\grid\SerialColumn::class],
                    ['attribute' => 'user_id',
                        'format' => "raw",
                        'filter' =>SelectDataHelper::dataSearchModel($searchModel, Schedule::find()->getAllColumnUser(),'user_id', 'profile.fio'),
                        'value' => function($model) {
                              return $model->profile->fio."<br />".$model->profile->phone."<br />".$model->email;
                        }],
                    [ 'attribute'=>'post',
                            'class' => \modules\management\components\PostColumn::class,
                        'filter' =>SelectDataHelper::dataSearchModel($searchModel, PostRateDepartment::find()->getAllColumn('name_short'),'post', ''),
                        'header'=> 'Должность'],
                    [ 'attribute'=>'isBlocked',
                        'format' => 'raw',
                        'filter' => ['Нет', 'Да'],
                        'value' => function(Schedule $model) {
                              return  Html::a($model->isBlocked ? 'Разблокировать': 'Заблокировать', ['blocked', 'id'=> $model->id,
                                  'is' => $model->isBlocked ? false: true], ['class'=> $model->isBlocked ? 'btn btn-success' : 'btn btn-danger']);
                        }
                    ],
                    ['class' => \modules\management\components\DataCombineColumn::class,
                        'attributes' => ['monday_even' => ['value' => function (Schedule $model) {
                              return 'Четная';
                        }], 'monday_оdd' => ['value' => function (Schedule $model) {
                            return 'Нечетная';
                        }],], 'headerTemplate'=>  "Неделя"],
                    ['class' => \modules\management\components\DataCombineColumn::class,
                        'attributes' => ['monday_even', 'monday_odd'], 'headerTemplate'=>  "Понедельник"],
                    ['class' => \modules\management\components\DataCombineColumn::class,
                        'attributes' => ['tuesday_even', 'tuesday_odd'], 'headerTemplate'=>  "Вторник"],
                    ['class' => \modules\management\components\DataCombineColumn::class,
                        'attributes' => ['wednesday_even', 'wednesday_odd'], 'headerTemplate'=>  "Среда"],
                    ['class' => \modules\management\components\DataCombineColumn::class,
                        'attributes' => ['thursday_even', 'thursday_odd'], 'headerTemplate'=>  "Четвверг"],
                    ['class' => \modules\management\components\DataCombineColumn::class,
                        'attributes' => ['friday_even', 'friday_odd'], 'headerTemplate'=>  "Пятница"],
                ]
            ]); ?>
        </div>
    </div>
</div>
