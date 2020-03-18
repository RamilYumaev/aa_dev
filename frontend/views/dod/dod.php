<?php

/* @var $this yii\web\View */

/* @var $dod dod\models\DateDod */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $dod->dodOne->name;
$this->params['breadcrumbs'][] = ['label' => 'Дни открытых дверей', 'url' => ['/dod']];
$this->params['breadcrumbs'][] = $this->title;
$url = Url::to($dod->broadcast_link, true)
?>
<div class="container">
    <h1><?= Html::encode($this->title) ?></h1>
    <p><i><?= $dod->formNameTypes ?></i></p>
    <?php if ($dod->haveDateTypes()): ?>
        <p><i><?= $dod->dateStartString ?></i></p>
        <p><i><?= $dod->timeStartString ?></i></p>
        <p><?= $dod->broadcast_link ? Html::a("Ссылка на вебинар", $url,
                ["class" => "btn btn-lg btn-warning"]) : "" ?></p>
    <?php elseif ($dod->haveFullInfoTypes()): ?>
        <p><i><?= $dod->dateStartString ?></i></p>
        <p><i><?= $dod->timeStartString ?></i></p>
        <p><?= $dod->dodOne->addressString ?></p>
        <p><?= $dod->dodOne->audNumberString ?></p>
        <p><?= $dod->broadcast_link ? Html::a("Ссылка на вебинар", $url,
                ["class" => "btn btn-lg btn-warning"]) : "" ?></p>
    <?php endif; ?>
    <?= $dod->textString ?>
</div>
