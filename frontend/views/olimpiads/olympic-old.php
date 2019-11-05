<?php
use yii\helpers\Html;
use frontend\widgets\olympictemplates\OlympicTemplatesWidget;

/* @var $this yii\web\View */
/* @var $olympic \olympic\models\OlimpicList */

$this->title = $olympic->name. " - ". $olympic->year;
?>
<div class="container-fluid">
    <p align="right"><?= $olympic->eduLevelString ?></p>
    <h1 align="center"><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-md-4"><p align="center"><?= $olympic->facultyNameString ?></p></div>
        <div class="col-md-4"><p align="center"><?= $olympic->numberOftoursNameString?> <br /> <?= $olympic->onlyMpguStudentsString ?></p></div>
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
            </div>
            <p class><a href="olympiads">Посмотреть другие олимпиады &gt;</a></p>
        </div>
    </div>
</div>
