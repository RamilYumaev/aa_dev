<?php

use yii\helpers\Html;
use modules\dictionary\helpers\DictDefaultHelper;
\frontend\assets\modal\ModalAsset::register($this);

$this->title = "Преимущественное право";
$this->params['breadcrumbs'][] = ['label' => 'Заполнение персональной карточки поступающего', 'url' => ['/abiturient/default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row min-scr">
    <div class="button-left">
        <?= Html::a(Html::tag("span", "", ["class" => "glyphicon glyphicon-arrow-left"]),
            "/abiturient", ["class" => "btn btn-warning btn-lg"]) ?>
    </div>
</div>

<div class="container">
    <div class="row">

         <?= \modules\entrant\widgets\other\PreemptiveRightWidget::widget(['userId' => $userId]) ?>
    </div>

</div>
