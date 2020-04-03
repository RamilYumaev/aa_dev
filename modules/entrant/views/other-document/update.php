<?php

/* @var $this yii\web\View */
/* @var $model modules\entrant\forms\OtherDocumentForm */
use yii\helpers\Html;
$this->title = "Прочие документы. Редактирование";
$this->params['breadcrumbs'][] = ['label' => 'Онлайн-регистрация', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title; ?>
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-30">
            <h1><?= Html::encode($this->title) ?></h1>
            <?= $this->render('_form', ['model' => $model]) ?>
        </div>
    </div>
</div>
