<?php

use backend\widgets\adminlte\Box;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

<?php Box::begin(
    [
        "header" => "Иные документы, удостоверяющие личность",
        "icon" => 'passport',
        "expandable" => true,
        ]) ?>
            <?= \yii\grid\GridView::widget([
                'tableOptions' => ['class' => 'table  table-bordered'],
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['attribute' => 'type', 'value' => 'typeName',],
                    ['attribute' => 'nationality', 'value' => 'nationalityName'],
                    ['value' => 'passportFull', 'header' => "Документ, удостоверяющий личность"],
                ],
            ]) ?>

<?php Box::end() ?>