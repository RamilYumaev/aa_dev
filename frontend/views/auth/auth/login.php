<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \shop\forms\auth\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<!--<div class="row">
    <div class="col-sm-6">
        <div class="well">

            <?php /*$form = ActiveForm::begin(['id' => 'login-form']); */?>

            <?/*= $form->field($model, 'username')->textInput() */?>

            <?/*= $form->field($model, 'password')->passwordInput() */?>

            <?/*= $form->field($model, 'rememberMe')->checkbox() */?>

            <div style="color:#999;margin:1em 0">
                Если Вы забыли пароль, то можете восстановить его <?/*= Html::a('reset it', ['auth/reset/request']) */?>.
            </div>

            <div>
                <?/*= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) */?>
            </div>

            <?php /*ActiveForm::end(); */?>
        </div>
    </div>
</div>-->

<div class="login-box">
    <div class="login-box-body">
        <?= Html::a('на главную', '/', ['class' => 'btn-lg']) ?>

        <div class="login-logo">
            <h2>Вход</h2>
        </div>

        <h4 class="login-box-msg">Для входа заполните, пожалуйста, форму:</h4>

        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
        <div class="form-group has-feedback">
            <?= $form->field($model, 'username')->label('Логин')->textInput(['class' => 'form-control']) ?>

            <?= $form->field($model, 'password')->passwordInput(['class' => 'form-control'])->label('Пароль') ?>

            <?= $form->field($model, 'rememberMe')->checkbox() ?>

        </div>
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <?= Html::submitButton('Войти', ['class' => 'btn btn-primary btn-lg btn-block', 'name' => 'login-button']) ?></div>
        </div>
        <?= Html::a('Забыли пароль?', 'request-password-reset') ?><br>
        <?= Html::a('Зарегистрироваться', ['site/signup']) ?>

        <?php ActiveForm::end() ?>
    </div>
</div>
