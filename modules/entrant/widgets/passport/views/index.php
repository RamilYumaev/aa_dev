<?php

use modules\entrant\helpers\PostDocumentHelper;
use yii\helpers\Html;
use modules\entrant\helpers\PassportDataHelper;
use modules\entrant\helpers\BlockRedGreenHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $userId integer*/

?>

<div class="row">
    <div class="col-md-12">
        <div class="p-30 mt-10 green-border">
            <h4>Иные документы, удостоверяющие личность</h4>
            <p ><span class="badge bg-red-light fs-15">Если Вы сдавали ЕГЭ по другому документу </span></p>
            <?= Html::a('Добавить', ['passport-data/create'], ['class' => 'btn btn-success mb-10']) ?>
            <?= \yii\grid\GridView::widget([
                'tableOptions' => ['class' => 'table  table-bordered'],
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['attribute' => 'type', 'value' => 'typeName',],
             /*       ['attribute' => 'nationality', 'value' => 'nationalityName'],*/
                    ['value' => 'passportFull', 'header' => "Документ, удостоверяющий личность"],
                    ['class' => \yii\grid\ActionColumn::class, 'controller' => 'passport-data', 'template' => '{update} {delete}']
                ],
            ]) ?>
        </div>
    </div>
</div>
