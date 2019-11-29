<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="box box-default">
    <div class="box box-header">
        <h4>Вопросы данного теста</h4>
        <?= Html::a('Добвить вопрос', ['/testing/question/types/type-select-one'], [ 'class'=>'btn btn-success']); ?>
        <?= Html::a('Добавить группу', ['/testing/question/types/type-matching'], [ 'class'=>'btn btn-success']); ?>
    </div>
    <div class="box-body">
        <?= \backend\widgets\adminlte\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['attribute' => 'test_group_id',
                  'value' => function ($model) {
                    return $model->test_group_id;
                  }],
                ['attribute' => 'question_id',
                    'value' => function ($model) {
                        return $model->question_id;
                    }],
                ['attribute' => 'mark',
                    'value' => function ($model) {
                        return Html::a(
                                'Выбрать вопросы',['/testing/test-and-questions/create',
                                    'test_id'=>$model->test_id, 'test_group_id'=> $model->id,
                                    'question_group_id'=> $model->question_group_id],
                            ['data-pjax' => 'w0', 'class' => 'btn btn-info', 'data-toggle' => 'modal', 'data-modalTitle' =>'Добавить вопросы', 'target' => '#modal']);
                        },
                ],
                ['label'=> '',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return Html::a(
                            'Создать вопрос','',
                            ['class' => 'btn btn-success']);
                    },
                ],

            ],
        ]) ?>
    </div>
</div>

