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
                'mark',
                ['header' => "Апелляция",
                    'value'=> function (ExamAttempt $model) {
                       return $model->status ? Html::a('Скачать pdf',['pdf','id' => $model->id])."/".Html::a('Скачать pdf (БПВ)',['pdf','id' => $model->id, 'is_correct'=>false ])  : "";
                    },
                    'format' => 'raw',
                ],
                ['class' => \yii\grid\ActionColumn::class,
                    'template' =>  '{view}' ,
                    'controller' => 'exam-attempt',
                ],
            ],
        ]) ?>
    </div>
</div>

