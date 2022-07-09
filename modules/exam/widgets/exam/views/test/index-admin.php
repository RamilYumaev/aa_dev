<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $exam_id int/
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="box box-default">
    <div class="box box-header">
        <h4>Тесты</h4>
    </div>
    <div class="box-body">
        <?= \backend\widgets\adminlte\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'name',
                ['header' => 'Сумма баллов',
                    'value' => function(\modules\exam\models\ExamTest $model) {
                        return $model->getExamQuestionInTest() ? $model->getExamQuestionInTest()->sum('mark') : "Нет данных";
                    }, "format" => "raw"],

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
                    'template' => ' {view}',
                    'controller' => 'exam-test',
                ],
            ],
        ]) ?>
    </div>
</div>

