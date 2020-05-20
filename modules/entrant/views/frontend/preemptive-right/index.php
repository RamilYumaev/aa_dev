<?php

use yii\helpers\Html;
use modules\dictionary\helpers\DictDefaultHelper;
\frontend\assets\modal\ModalAsset::register($this);

$this->title = "Преимущественное право";
$this->params['breadcrumbs'][] = ["label" => "Онлайн-регистрация", "url" => "/abiturient/default"];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
    <div class="row">
         <?= \modules\entrant\widgets\other\PreemptiveRightWidget::widget(['userId' => $userId]) ?>
    </div>

</div>
