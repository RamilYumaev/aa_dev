<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

\common\auth\actions\assets\LoginAsset::register($this);
$this->title = 'Сброс пароля';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-box">
    <div class="login-box-body">
        <?= Html::a('на главную', '/', ['class' => 'btn-lg']) ?>
        <div class="login-logo">
            <h2>Сброс пароля</h2>
        </div><!-- /.login-logo -->
        <h4 class="login-box-msg">Пожалуйста, введите новый пароль:</h4>
        <?php $form = ActiveForm::begin(['id' => 'form-reset']); ?>
        <div class="form-group has-feedback">
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'password_repeat')->passwordInput() ?>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary btn-lg btn-block', 'name' => 'login-button']) ?></div>
        </div>
        <?php ActiveForm::end() ?>
    </div>
</div>

