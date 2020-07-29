<?php

use yii\helpers\Html;
use modules\entrant\helpers\StatementHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $userId integer */

?>
<div class="row">
    <div class="col-md-12">
        <div class="p-30 green-border">
            <h4>Результаты ЕГЭ:</h4>
            <?= Html::a('Добавить', ['cse-subject-result/create'], ['class' => 'btn btn-success mb-10']) ?>
            <?= \yii\grid\GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'year',
                    ['attribute' => 'result', 'value' => 'dataResult', 'format' => 'raw'],
                    ['class' => \yii\grid\ActionColumn::class, 'controller' => 'cse-subject-result', 'template' => '{update}{delete}']
                    /*['class' => \yii\grid\ActionColumn::class, 'controller' => 'cse-subject-result', 'template' => StatementHelper::isStatementSend($userId) ? '{update}{link}{delete}' : '{update}{delete}' ,
                        'buttons' => [
                            'link' => function ($url,$model) {
                                return Html::a(
                                    'Добавить ЕГЭ',
                                    ['cse-subject-result/add', 'id'=>$model->id], ['data-pjax' => 'w0',
                                        'class'=> 'btn btn-warning', 'data-toggle' => 'modal', 'data-modalTitle' =>'Добавить ЕГЭ -'.$model->year, 'data-target' => '#modal']);
                            },
                        ]]*/
                    ]
            ]) ?>
        </div>
    </div>
</div>
