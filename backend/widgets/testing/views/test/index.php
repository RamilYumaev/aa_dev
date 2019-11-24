<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $olympic_id int/
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="box box-default">
    <div class="box box-header">
        <h4>Тесты</h4>
        <?=Html::a('Добавить', ['testing/test/create','olympic_id' => $olympic_id],
            ['data-pjax' => 'w0', 'data-toggle' => 'modal', 'target' => '#modal', 'data-modalTitle' =>'Добавить', 'class'=>'btn btn-primary']) ?>
    </div>
    <div class="box-body">
        <?= \backend\widgets\adminlte\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['label'=>"Классы(курсы)",
                    'value' => function($model) {
                        return \testing\helpers\TestClassHelper::TestClassString($model->id);
                    }],
                [
                    'value' => function($model) {
                        return Html::a('Запустить тест','',  ['class'=>'btn btn-success']);
                    }, "format" => "raw"],
                [
                    'value' => function($model) {
                        return Html::a("Банк вопросов",['testing/test/view', 'id'=>$model->id], ['class'=>'btn btn-info']);
                    },
                    "format" => "raw"
                    ],
                ['class' => \yii\grid\ActionColumn::class,
                    'template' => '{update} {delete}',
                    'controller' => 'testing/test',
                    'buttons' => [
                        'update' => function ($url,$model) {
                            return Html::a(
                                '<span class="glyphicon glyphicon-edit"></span>',
                                $url, ['data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-modalTitle' =>'Редактировать', 'target' => '#modal']);
                        },
                    ]
                ],
            ],
        ]) ?>
    </div>
</div>

