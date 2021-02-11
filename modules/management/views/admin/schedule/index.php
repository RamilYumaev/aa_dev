<?php

use modules\entrant\helpers\SelectDataHelper;
use modules\management\models\Schedule;
use backend\widgets\adminlte\grid\GridView;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel modules\management\searches\ScheduleSearch */

$this->title = 'Графики';
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
                    ['attribute' => 'rate',
                     'filter' => (new Schedule())->getRateList(),
                      'value' => 'rateName'],
                    [ 'attribute'=>'post',
                            'class' => \modules\management\components\PostColumn::class,
                        'filter' =>SelectDataHelper::dataSearchModel($searchModel, \modules\management\models\PostManagement::find()->allColumn(),'post', ''), 'header'=> 'Должность'],
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
