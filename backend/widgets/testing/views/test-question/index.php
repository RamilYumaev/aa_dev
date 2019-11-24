<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="box box-default">
    <div class="box box-header">
        <h4>Группы вопросов данного теста</h4>
    </div>
    <div class="box-body">
        <?= \backend\widgets\adminlte\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['attribute' => 'question_group_id',
                  'value' => function ($model) {
                    return \testing\helpers\TestQuestionGroupHelper::testQuestionGroupName($model->question_group_id);
                  }],
                ['label'=> "Количество вопросов",
                    'value' => function ($model) {
                        return \testing\helpers\TestAndQuestionsHelper::questionTestGroupCount($model->id);
                    }],
                ['label'=> '',
                    'format' => 'raw',
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

