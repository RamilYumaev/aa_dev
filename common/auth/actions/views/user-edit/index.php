<?php

/* @var $this yii\web\View */

/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
\common\auth\actions\assets\LoginAsset::register($this);

$this->title = 'Настройки системы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-box">
    <div class="login-box-body">
        <div class="login-logo">
            <?= \common\widgets\Alert::widget() ?>
            <?= Html::a('Подтвердить', ['sign-up/confirm-user'], ['class' => 'btn btn-success btn-lg']) ?>
            <h2>Настройки системы</h2>
        </div><!-- /.login-logo -->
        <h4 class="login-box-msg"></h4>
        <?php $form = ActiveForm::begin(['id' => 'form-edit-user']); ?>
        <div class="form-group has-feedback">
            <?= $form->field($model, 'username') ?>
            <?= $form->field($model, 'email') ?>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary btn-lg', 'name' => 'login-button']) ?>
            </div>
        </div>

        <?php ActiveForm::end() ?>
    </div>
</div>
