<?php

use modules\exam\helpers\ExamResultHelper;
use modules\exam\models\ExamAttempt;
use olympic\helpers\auth\ProfileHelper;
use testing\helpers\TestResultHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="box box-default">
    <div class="box box-header">
        <h4>Попытки данного теста</h4>
    </div>
    <div class="box-body">
        <?= \backend\widgets\adminlte\grid\GridView::widget([
            'rowOptions' => function( ExamAttempt $model){
                if ((!is_null($model->mark) && is_null($model->mark)) && ExamResultHelper::isPreResult($model->id)) {
                    return ['class' => 'warning'];
                } elseif( !is_null($model->mark) && ExamResultHelper::isPreResultAll($model->id)) {
                    return ['class' => 'warning'];
                } else {
                    return  is_null($model->mark) ? ['class' => 'default'] :['class' => 'success'];
                }
            },
            'dataProvider' => $dataProvider,
            'columns' => [
                ['attribute' => "user_id",
                    'value'=> 'profile.fio'
                ],
                'start:datetime',
                'end:datetime',
               // 'mark',
                ['class' => \yii\grid\ActionColumn::class,
                    'template' => !\common\auth\helpers\UserHelper::isManagerOlympic()  ?'{view}' : '{view}' ,
                    'controller' => 'exam-attempt',
                ],
            ],
        ]) ?>
    </div>
</div>

