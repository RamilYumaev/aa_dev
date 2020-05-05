<?php
/* @var $this yii\web\View */
/* @var $hash string */
/* @var $id integer */

use yii\helpers\Html;
?>
<?= Html::a("Загрузить", ["file/download", "hash" => $hash, 'id' => $id], ["class" => "btn btn-primary",
        'data-pjax' => 'w0', 'data-toggle' => 'modal',
        'data-target' => '#modal', 'data-modalTitle' => 'Добавить'.$id]) ?>

