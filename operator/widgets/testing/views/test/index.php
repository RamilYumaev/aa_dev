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
            ['data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' =>'Добавить', 'class'=>'btn btn-primary']) ?>
    </div>
    <div class="box-body">
        <?= \operator\widgets\adminlte\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['label'=>"Классы(курсы)",
                    'value' => function($model) {
                        return \testing\helpers\TestClassHelper::TestClassString($model->id);
                    }],
                [
                    'value' => function($model) {
                        return !$model->status ?
                            Html::a('Запустить тест',['testing/test/start', 'id'=>$model->id],  ['class'=>'btn btn-success']) :
                            Html::a('Остановить тест',['testing/test/end', 'id'=>$model->id],  ['class'=>'btn btn-danger']);
                    }, "format" => "raw"],

                ['class' => \yii\grid\ActionColumn::class,
                    'template' => '{update} {view} {delete}',
                    'controller' => 'testing/test',
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

