<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use modules\entrant\helpers\UserCgHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="row">
    <div class="col-md-12 <?= BlockRedGreenHelper::colorBg(UserCgHelper::findUser()) ?>" >
        <h4>Образовательные программы:</h4>
        <?= Html::a('Поиск', ['anketa/step2'], ['class' => 'btn btn-warning mb-10']) ?>
        <?= \yii\grid\GridView::widget([
                'tableOptions' => ['class' => 'table  table-bordered'],
            'dataProvider' => $dataProvider,
            'columns' => [
                ['attribute'=>'cg_id', 'value' => 'cg.fullNameCg'],
            ],
        ]) ?>
    </div>
</div>
