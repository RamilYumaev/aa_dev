<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $olympic_id int/
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel testing\forms\search\TestQuestionGroupSearch */

?>
<div class="box box-default">
    <div class="box box-header">
        <h4>Группа вопросов</h4>
        <?=Html::a('Добавить', ['testing/test-question-group/create','olympic_id' => $olympic_id],
            ['data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' =>'Добавить', 'class'=>'btn btn-primary']) ?>
    </div>
    <div class="box-body">
        <?= \backend\widgets\adminlte\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                'name',
                ['attribute'=>'year',
                    'filter' => $searchModel->yearList(),
                    'value' => 'year',],
                ['class' => \yii\grid\ActionColumn::class,
                    'template' => '{update} {delete}',
                    'controller' => 'testing/test-question-group',
                    'buttons' => [

                        'update' => function ($url,$model) {
                            return Html::a(
                                '<span class="glyphicon glyphicon-edit"></span>',
                                $url, ['data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-modalTitle' =>'Редактировать', 'data-target' => '#modal']);
                        },
                    ]
                ],
            ],
        ]) ?>
    </div>
</div>

