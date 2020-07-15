<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $exam_id int/
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="box box-default">
    <div class="box box-header">
        <h4>Тесты</h4>
        <?=Html::a('Добавить', ['exam-test/create','exam_id' => $exam_id],
            ['data-pjax' => 'w7', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' =>'Добавить', 'class'=>'btn btn-primary']) ?>
    </div>
    <div class="box-body">
        <?= \backend\widgets\adminlte\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'name',
                [
                    'value' => function($model) {
                        return !$model->status ?
                            Html::a('Запустить тест',['exam-test/start', 'id'=>$model->id],  ['class'=>'btn btn-success']) :
                            Html::a('Остановить тест',['exam-test/end', 'id'=>$model->id],  ['class'=>'btn btn-danger']);
                    }, "format" => "raw"],
                [
                    'value' => function($model) {
                        return
                            Html::a("Пробный тест", ['exam-attempt/start',
                                'test_id'=> $model->id],
                                ['data' => ['confirm' => 'Вы действительно хотите начать пробный тест?', 'method' => 'POST'],
                                    'class' =>'btn btn-primary']);
                    }, "format" => "raw"],
                ['class' => \yii\grid\ActionColumn::class,
                    'template' => '{update} {view} {delete}',
                    'controller' => 'exam-test',
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

