<?php
/** @var $queues array */
$this->title = "Электронная очередь";
use yii\helpers\Html;
use yii\widgets\Pjax; ?>
<?php
$script = <<<JS
$(document).ready(function() {
    setInterval(function(){
        location.reload();
    }, 1000000);
});
JS;
$this->registerJs($script);
?>
<?php Pjax::begin(); ?>
<style type="text/css" scoped>
#queue{
    font-family: 'Lato', 'Roboto', sans-serif;
}
.tablo__talon{
    margin: 0 auto;
    display: block;
    text-align: center;
    font-size: 145px;
    font-weight: 600;
    margin-top: 40px;
    color: #262626;
}
</style>
<div id="queue">
    

<div class="tablo__talons">
<?php foreach ($queues as $key => $queue)  : ?>
    <div class='tablo__talon' >
        <?= $queue['talon'] ?>
        – 
        <?= $queue['number_of_table'] ?>
    </div>
            
        <?php endforeach; ?></tbody>
    
</div>
<?php Pjax::end(); ?>
