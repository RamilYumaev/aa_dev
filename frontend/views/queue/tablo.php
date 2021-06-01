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
<div id="queue">
    <h1> <span style="color: blue">Новый</span> <span style="color:green">Повторный</span> <span style="color:red">Старый</span></h1>
    <table>
        <thead>
        <tr>
            <th>Талон</th>
            <th>Стол</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($queues as $key => $queue) : ?>
            <tr>
                <th><?= $queue['talon'] ?></th>
                <th><?= $queue['number_of_table'] ?></th>
            </tr>
        <?php endforeach; ?></tbody>
    </table>
</div>
<?php Pjax::end(); ?>