<?php

/**
 * @var $logFile
 */

use yii\helpers\Html;

?>
<div class="mt-30 ml-10">
<?=Html::a("Очистить", ["app-log-clear"],  ["class"=> "btn btn-primary"])?>
</div>
<div class="container mt-50">
    <div class="row">
        <?php
        echo \nl2br(Html::encode(@\file_get_contents($logFile)));

        ?>
    </div>
</div>
