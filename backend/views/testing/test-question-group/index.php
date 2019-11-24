<?php

use backend\widgets\adminlte\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel testing\forms\search\TestQuestionGroupSearch */

$this->title = 'Группы вопросов';
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
                 $name = \olympic\helpers\OlympicHelper::olympicName($model->olimpic_id);
                 return Html::a($name, ['olympic/olympic/view', 'id'=>$model->olimpic_id]);
                }],
            'name',
                ['attribute'=>'year',
                    'filter' => $searchModel->yearList(),
                    'value' => 'year',],
                ['label' => 'Количество вопросов',
                    'value' => function($model) {
                 return \testing\helpers\TestQuestionHelper::questionGroupCount($model->id);
                    }
                ],
                ['class' => \yii\grid\ActionColumn::class, 'template'=> '{view}'],
            ]]) ?>
    </div>
</div>

