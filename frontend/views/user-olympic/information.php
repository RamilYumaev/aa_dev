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
        <div class="col-md-10 col-md-offset-1 mb-30">
            <h3>Необходимо выбрать 2 предметных секций</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php if (!Yii::$app->user->isGuest && $olympic->olympicOneLast->isOnRegisterOlympic) : ?>
                <?= $this->render('_form', ['model' => $model]) ?>
            <?php endif; ?>
        </div>
    </div>
</div>
