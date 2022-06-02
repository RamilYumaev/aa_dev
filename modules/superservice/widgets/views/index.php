<?php
/** @var string $category */
/** @var array $data */

use yii\helpers\Html;
\frontend\assets\modal\ModalAsset::register($this);
$disabled = 0;
if($data) {
    $disabled = 0;
} else {
    $disabled = 1;
}
?>
<?= Html::a("Выбрать тип документа", ['/ss/default/form', 'category'=> $category], ["class" => "btn btn-warning",
    'data-pjax' => 'w3', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' => 'Выбор типа документа'])?>
<?php if($data): ?>
    <h4>Ваш тип документа: <?= $data[0]['Name'] ?></h4>
<?php endif; ?>
<?php
$this->registerJs(<<<JS
var isDisabled = $disabled;
"use strict";
if(isDisabled) {
    $('input').prop('disabled', true);
    $('[type=submit]').prop('disabled', true);
}else {
    $('input').prop('disabled', false);
    $('[type=submit]').prop('disabled', false);
}
JS
);
?>