<?php

use yii\helpers\Html;
use frontend\widgets\olympictemplates\OlympicTemplatesWidget;
use frontend\widgets\olympicold\OlympicOldWidget;
use frontend\widgets\olympic\OlympicResultWidget;
use frontend\widgets\olympic\UserOlympicWidget;

/* @var $this yii\web\View */
/* @var $olympic olympic\models\Olympic */
/* @var $model olympic\forms\SignupOlympicForm */


$url = \yii\helpers\Url::to(['/olympiads']);
$this->title = $olympic->name;
$this->params['breadcrumbs'][] = ['label' => 'Олимпиады и конкурсы', 'url' => $url];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid olimp bg<?= rand(1, 3) ?>">
    <p align="right"><?= $olympic->olympicOneLast->eduLevelString ?></p>
    <h1 align="center"><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-md-4"><p align="center"><?= $olympic->olympicOneLast->facultyNameString ?></p></div>
        <div class="col-md-4"><p align="center"><?= $olympic->olympicOneLast->numberOftoursNameString ?>
                <br/><?= $olympic->olympicOneLast->onlyMpguStudentsString ?></p></div>
        <div class="col-md-4"><p align="center"><?= $olympic->olympicOneLast->formOfPassageString ?></p></div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-7">
            <p><?= $olympic->olympicOneLast->dateRegStartNameString ?></p>
            <p><?= $olympic->olympicOneLast->dateRegEndNameString ?> </p>
            <p><?= $olympic->olympicOneLast->timeOfDistantsTourNameString ?></p>
            <p><?= $olympic->olympicOneLast->timeStartTourNameString ?></p>
            <p><?= $olympic->olympicOneLast->addressNameString ?></p>
            <p><?= $olympic->olympicOneLast->timeOfTourNameString ?></p>
            <?= $olympic->olympicOneLast->contentString ?>
            <?php if (Yii::$app->user->isGuest && $olympic->olympicOneLast->isOnRegisterOlympic) : ?>
                <?= $this->render('_form', ['model' => $model]) ?>
            <?php endif; ?>
        </div>
        <div class="col-md-5">
            <div class="control-panel">
                <?= OlympicTemplatesWidget::widget(['model' => $olympic->olympicOneLast]) ?>
                <?= OlympicResultWidget::widget(['model' => $olympic->olympicOneLast]) ?>
                <?= OlympicOldWidget::widget(['model' => $olympic]) ?>
                <?php if (!Yii::$app->user->isGuest && $olympic->olympicOneLast->isOnRegisterOlympic) : ?>
                    <?= UserOlympicWidget::widget(['model' => $olympic->olympicOneLast]) ?>
                <?php endif; ?>
            </div>
            <p class><a href="<?= Html::encode($url) ?>">Посмотреть другие олимпиады &gt;</a></p>
        </div>
    </div>
</div>
