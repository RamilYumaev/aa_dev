<?php
/* @var $this yii\web\View */
?>

<?=\yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider,
    'layout' => "{items}\n{pager}",
    'itemView' => '_olimpic',
]) ?>