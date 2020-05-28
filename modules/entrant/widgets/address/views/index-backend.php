<?php

use backend\widgets\adminlte\Box;

/* @var $this yii\web\View */
/* @var $userId integer */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<?php Box::begin(
    ["header" => "Адреса регистрации и проживания:", "type" => Box::TYPE_PRIMARY,
        "collapsable" => true,
    ]
)
?>
<?= \yii\grid\GridView::widget([
    'tableOptions' => ['class' => 'table  table-bordered'],
    'dataProvider' => $dataProvider,
    'columns' => [
        ['attribute' => 'type', 'value' => 'typeName'],
        ['attribute' => 'country_id', 'value' => 'countryName'],
        ['value' => 'addersFull', 'header' => "Адрес"],
    ],
]) ?>
<?php Box::end() ?>

