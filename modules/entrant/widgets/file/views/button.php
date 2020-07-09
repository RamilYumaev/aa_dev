<?php
/* @var $this yii\web\View */
/* @var $hash string */
/* @var $url string */
/* @var $link string */
/* @var $id integer */

use yii\helpers\Html;
?>
<span id="<?=$link.$id ?>"></span>
<?= Html::a("Загрузить скан  (jpg, png, jpeg)", [$url, "hash" => $hash, 'id' => $id], ["class" => "btn btn-info",
        'data-pjax' => 'w0', 'data-toggle' => 'modal',
        'data-target' => '#modal', 'data-modalTitle' => 'Загрузить скан']) ?>

