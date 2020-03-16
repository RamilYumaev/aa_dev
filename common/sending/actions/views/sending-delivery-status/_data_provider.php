<?php

/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $columns array */
?>

<div class="box">
    <div class="box-header">
    </div>
    <div class="box-body">
        <?= \backend\widgets\adminlte\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'rowOptions' => function( \common\sending\models\SendingDeliveryStatus $model){
                if ($model->isStatusRead()) {
                    return ['class' => 'success'];
                }
            },
            'columns' => $columns
        ]); ?>
    </div>
</div>