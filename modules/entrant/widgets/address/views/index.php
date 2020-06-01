<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use modules\entrant\helpers\AddressHelper;

/* @var $this yii\web\View */
/* @var $userId integer */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="row">
    <div class="col-md-12 <?= BlockRedGreenHelper::colorBg(AddressHelper::isExits($userId)) ?>">
        <div class="p-30 green-border">
        <h4>Адреса регистрации и проживания:</h4>
            <p> <span class="badge bg-red-light">В этом блоке необходимо обязательно указать фактический адрес Вашего
                    проживания и адрес регистрации (постоянной и/или временной)</span></p>
        <?= Html::a('Добавить', ['address/create'], ['class' => 'btn btn-success mb-10']) ?>
        <?= \yii\grid\GridView::widget([
            'tableOptions' => ['class' => 'table  table-bordered'],
            'dataProvider' => $dataProvider,
            'columns' => [
                ['attribute' => 'type', 'value' => 'typeName'],
                ['attribute' => 'country_id', 'value' => 'countryName'],
                ['value' => 'addersFull', 'header' => "Адрес"],
                ['class' => \yii\grid\ActionColumn::class, 'controller' => 'address', 'template' => '{update}{delete}']
            ],
        ]) ?>
    </div>
</div>
</div>
