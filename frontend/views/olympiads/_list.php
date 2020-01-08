<?php
/* @var $this yii\web\View */
?>
<?=\yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider,
    'layout' => "{items}\n{pager}",
    'beforeItem' => function($model , $key , $index , $widget) {
          return  $index%3 == 0 ? '<div class="row">':"";
        },
    'afterItem' => function($model , $key , $index , $widget) {
          return  $index%3 == 2 ? '</div>': "";
        } ,
    'itemView' => '_olympic',
]) ?>