<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

<div class="row">
    <div class="col-md-12">
        <h4>Паспортые данные</h4>
        <?= Html::a('Добавить', ['passport-data/create'], ['class' => 'btn btn-success mb-10']) ?>
        <?= \yii\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['attribute'=>'type', 'value' => 'typeName',],
                ['attribute'=>'nationality', 'value' => 'nationalityName'],
                ['value'=> 'passportFull', 'header' =>  "Паспортные данные"],
                ['class'=> \yii\grid\ActionColumn::class, 'controller' => 'passport-data', 'template'=> '{update} {delete}']
            ],
        ]) ?>
    </div>
</div>
