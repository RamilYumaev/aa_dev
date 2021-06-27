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
    }, 3000);
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
    font-size: 120px;
    font-weight: 600;
    margin-top: 30px;
    color: #262626;
}
img{
    display: block;
    height: 200px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);

}
</style>
<div id="queue">

<div class="tablo__talons">

<?php if (count($queues)!==0): ?> 
    <?php foreach ($queues as $key => $queue)  : ?>
        <div class='tablo__talon' >
            <?= $queue['talon'] ?>
            – 
            <?= $queue['number_of_table'] ?>
        </div>
    <?php endforeach; ?></tbody>
<?php else: ?>
    <img src="../img/cabinet/logo_aa.png">
<?php endif ?>
    
</div>
<?php Pjax::end(); ?>
