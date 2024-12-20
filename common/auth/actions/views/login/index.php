<?php

/* @var $this yii\web\View */

/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\widgets\Alert;

\common\auth\actions\assets\LoginAsset::register($this);
$this->title = 'Вход';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-box">
    <div class="login-box-body">
        <?= Alert::widget() ?>

        <?= Html::a('на главную', '/', ['class' => 'btn-lg']) ?>

        <div class="login-logo">
            <h2>Вход</h2>
        </div>
        <p align="center">Войдите с помощью:</p>
        <div class="row">
            <div class="col-md-offset-3 col-md-6">
                <?= yii\authclient\widgets\AuthChoice::widget([
                    'baseAuthUrl' => ['account/auth'],
                    'popupMode' => false,
                ]) ?>
                <?php if($_SERVER['HTTP_HOST'] == "sdo.mpgu.org") : ?>
                <center>
                <script async src="https://telegram.org/js/telegram-widget.js?11" data-telegram-login="MpguBot" data-size="large" data-onauth="onTelegramAuth(user)" data-request-access="write"></script>
                <script type="text/javascript">
                    function onTelegramAuth(user) {
                        $.ajax({
                            url: '/account/auth-telegram',
                            method: 'post',
                            data: user,
                            dataType:'json',
                            success: function (data) {

                                window.location.href = '/';

                            },
                            error: function (error) {
                                alert(error);

                            }

                        })
                    }
                </script>
                </center>
                <?php endif; ?>
            </div>
        </div>
        <h4 class="login-box-msg">или заполните, пожалуйста, форму:</h4>

        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
        <div class="form-group has-feedback">
            <?= $form->field($model, 'username')->label('Логин')->textInput() ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'rememberMe')->checkbox() ?>

        </div>
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <?= Html::submitButton('Войти', ['class' => 'btn btn-primary btn-lg btn-block', 'name' => 'login-button']) ?></div>
        </div>
        <?= Html::a('Забыли пароль?', ['/reset/request']) ?><br>
        <?= Html::a('Зарегистрироваться', ['/sign-up/request']) ?>

        <?php ActiveForm::end() ?>
    </div>
</div>