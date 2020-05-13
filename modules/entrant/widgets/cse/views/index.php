<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
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
                ],
            ]) ?>
        </div>
    </div>
</div>
