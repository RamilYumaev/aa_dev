<?php

use testing\helpers\TestQuestionHelper;
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
            'rowOptions' => function( \testing\models\TestResult $model){
                if (($model->question->type_id == TestQuestionHelper::TYPE_ANSWER_DETAILED ||
                        $model->question->type_id == TestQuestionHelper::TYPE_FILE)  &&  is_null($model->mark)) {
                    return ['class' => 'warning'];
                }
                 else {
                     return ['class' => 'default'];
                }
            },
            'columns' => [
               ['attribute'=>'question_id',
               'class'=> \backend\widgets\testing\gird\ViewAnswerAttemptTestColumn::class],
                'updated:datetime',
                'mark',
                ['class' => \yii\grid\ActionColumn::class,
                    'template' => '{update}',
                    'controller' => 'testing/test-result',
                    'buttons'=> [
                        'update' => function ($url,$model) {
                            return $model->question->type_id  == TestQuestionHelper::TYPE_ANSWER_DETAILED ||
                            $model->question->type_id  == TestQuestionHelper::TYPE_FILE ?
                                Html::a(
                                '<span class="glyphicon glyphicon-edit"></span>',
                                   ['/testing/test-result/update', 'attempt_id' => $model->attempt_id,
                                       'question_id' => $model->question_id, 'tq_id' =>$model->tq_id], ['data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-modalTitle' =>'Редактировать оценку', 'data-target' => '#modal']) :"";
                        },
                ],
            ],
        ]]) ?>
    </div>
</div>

