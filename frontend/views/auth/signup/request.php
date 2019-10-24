<?php

/* @var $this yii\web\View */

/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;


$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-box">

    <div class="login-box-body">
        <?= Html::a('на главную', '/', ['class' => 'btn-lg']) ?>

        <div class="login-logo">
            <h2>Регистрация</h2>
        </div><!-- /.login-logo -->
        <h4 class="login-box-msg">зарегистрируйтесь с помощью:</h4>
        <? /* yii\authclient\widgets\AuthChoice::widget([
            'baseAuthUrl' => ['site/auth'],
            'popupMode' => false,
        ]) */ ?>

        <h4 class="login-box-msg">или заполните форму:</h4>

        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
        <div class="form-group has-feedback">
            <?= $form->field($model, 'username') ?>
            <?= $form->field($model, 'email') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'password_repeat')->passwordInput() ?>
            <?= $form->field($model, 'agree')->checkbox([
                'template' => "{beginWrapper}\n<div class=\"checkbox\">\n{beginLabel}\n{input}\n{labelTitle}\n{endLabel}\n</div>
        <a href=\"/uploads/consent.pdf\" target=\"_blank\">
        Ознакомиться</a>\n{error}\n{endWrapper}\n{hint}",
            ]) ?>
            <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                       'captchaAction' => ['/auth/signup/captcha'],
                'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6 col-lg-offset-1">{input}</div></div>',
            ]) ?>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary btn-lg btn-block', 'name' => 'login-button']) ?></div>
        </div>

        <?php ActiveForm::end() ?>
    </div>
