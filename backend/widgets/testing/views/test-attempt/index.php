<?php

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
            'dataProvider' => $dataProvider,
            'columns' => [
                ['attribute' => "ФИО участника",
                    'class' => \backend\widgets\testing\gird\ButtonResultAnswerAttemptTestColumn::class,
                ],
                'start:datetime',
                'end:datetime',
                'mark',
                ['class' => \yii\grid\ActionColumn::class,
                    'template' => !\common\auth\helpers\UserHelper::isManagerOlympic()  ?'{view} {delete}' : '{view}' ,
                    'controller' => 'testing/test-attempt',
                ],
            ],
        ]) ?>
    </div>
</div>

