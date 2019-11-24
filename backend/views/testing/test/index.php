<?php

use backend\widgets\adminlte\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel testing\forms\search\TestSearch */

$this->title = 'Тесты';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="box box-default">
    <div class="box box-header">
    <div class="box-body">
             <?= GridView::widget([
            'dataProvider' => $dataProvider,
                 'filterModel' => $searchModel,
            'columns' => [
            ['attribute'=>'olimpic_id',
                'format'=> "raw",
                'filter' => $searchModel->olympicList(),
                'value' => function ($model) {
                 $name = \olympic\helpers\OlympicListHelper::olympicAndYearName($model->olimpic_id);
                 return Html::a($name, ['olympic/olimpic-list/view', 'id'=>$model->olimpic_id]);
                }],
                ['label' => "Классы(курсы)",
                    'value' => function($model) {
                        return \testing\helpers\TestClassHelper::TestClassString($model->id);
                    }],
                [
                    'value' => function($model) {
                        return Html::a('Запустить тест','',  ['class'=>'btn btn-success']);
                    }, "format" => "raw"],
                [
                    'value' => function($model) {
                        return Html::a("Банк вопросов",['view', 'id'=>$model->id], ['class'=>'btn btn-info']);
                    },
                    "format" => "raw"
                ],
            ]]) ?>
    </div>
</div>

