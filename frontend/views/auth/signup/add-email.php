<?php

/* @var $this yii\web\View */

/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;


$this->title = 'Добавление электронной почты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-box">
    <div class="login-box-body">

        <div class="login-logo">
            <h2>Добавление электронной почты</h2>
        </div><!-- /.login-logo -->

        <h4 class="login-box-msg">У Вас отсутствует электронная почта, заполните пожалуйста</h4>

        <?php $form = ActiveForm::begin(['id' => 'form-add-email']); ?>
        <div class="form-group has-feedback">
            <?= $form->field($model, 'email') ?>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary btn-lg btn-block', 'name' => 'login-button']) ?></div>
        </div>

        <?php ActiveForm::end() ?>
    </div>
