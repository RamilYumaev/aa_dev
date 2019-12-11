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
               ['attribute'=>'question_id',
               'class'=> \backend\widgets\testing\gird\ViewAnswerAttemptTestColumn::class],
                'updated:datetime',
                'mark',
                ['class' => \yii\grid\ActionColumn::class,
                    'template' => '{update}',
                    'controller' => 'testing/test-attempt',
                ],
            ],
        ]) ?>
    </div>
</div>

