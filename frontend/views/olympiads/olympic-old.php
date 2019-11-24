<?php

use yii\helpers\Html;
use frontend\widgets\olympictemplates\OlympicTemplatesWidget;
use frontend\widgets\olympic\OlympicResultWidget;

/* @var $this yii\web\View */
/* @var $olympic \olympic\models\OlimpicList */

$url = \yii\helpers\Url::to(['/olympiads']);
$this->title = $olympic->name . " - " . $olympic->year;
$this->params['breadcrumbs'][] = ['label' => 'Олимпиады и конкурсы', 'url' => $url];
$this->params['breadcrumbs'][] = ['label' => \olympic\helpers\OlympicHelper::olympicName($olympic->olimpic_id),
    'url' => ['registration-on-olympiads', 'id' => $olympic->olimpic_id]];
$this->params['breadcrumbs'][] = $olympic->year;
?>
<div class="container-fluid olimp bg<?= rand(1, 3) ?>">
    <p align="right"><?= $olympic->eduLevelString ?></p>
    <h1 align="center"><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-md-4"><p align="center"><?= $olympic->facultyNameString ?></p></div>
        <div class="col-md-4"><p align="center"><?= $olympic->numberOftoursNameString ?>
                <br/> <?= $olympic->onlyMpguStudentsString ?></p></div>
        <div class="col-md-4"><p align="center"><?= $olympic->formOfPassageString ?></p></div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-7">
            <p><?= $olympic->dateRegStartNameString ?></p>
            <p><?= $olympic->dateRegEndNameString ?> </p>
            <p><?= $olympic->timeOfDistantsTourNameString ?></p>
            <p><?= $olympic->timeStartTourNameString ?></p>
            <p><?= $olympic->addressNameString ?></p>
            <p><?= $olympic->timeOfTourNameString ?></p>
            <?= $olympic->contentString ?>
        </div>
        <div class="col-md-5">
            <div class="control-panel">
                <?= OlympicTemplatesWidget::widget(['model' => $olympic]) ?>
                <?= OlympicResultWidget::widget(['model' => $olympic]) ?>
            </div>
            <p class><a href="<?= Html::encode($url) ?>">Посмотреть другие олимпиады &gt;</a></p>
        </div>
    </div>
</div>
