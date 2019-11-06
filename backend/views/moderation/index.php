<?php

use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Модерация';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="moderation">
    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => yii\grid\SerialColumn::class],
                    'model',
                    'record_id',
                    ['class' => ActionColumn::class],
                ]
            ]); ?>
        </div>
    </div>
</div>

