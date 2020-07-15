<?php

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
            'rowOptions' => function( \modules\exam\models\ExamAttempt $model){
                if ((!is_null($model->mark) && is_null($model->mark)) && TestResultHelper::isPreResult($model->id)) {
                    return ['class' => 'warning'];
                } elseif( !is_null($model->mark) && TestResultHelper::isPreResultAll($model->id)) {
                    return ['class' => 'warning'];
                } else {
                    return  is_null($model->mark) ? ['class' => 'default'] :['class' => 'success'];
                }
            },
            'dataProvider' => $dataProvider,
            'columns' => [
                ['attribute' => "ФИО участника",
                    'value'=> function ($model) {
                      return  ProfileHelper::profileFullName($model->user_id);
                    }
                ],
                'start:datetime',
                'end:datetime',
                'mark',
                ['class' => \yii\grid\ActionColumn::class,
                    'template' => !\common\auth\helpers\UserHelper::isManagerOlympic()  ?'{view}' : '{view}' ,
                    'controller' => 'exam-attempt',
                ],
            ],
        ]) ?>
    </div>
</div>

