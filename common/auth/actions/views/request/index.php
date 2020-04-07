<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

\common\auth\actions\assets\LoginAsset::register($this);
$this->title = 'Восстановление доступа';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-box">
    <div class="login-box-body">
        <?= Html::a('на главную', '/', ['class' => 'btn-lg']) ?>
        <div class="login-logo">
            <h2><?= $this->title ?> </h2>
        </div><!-- /.login-logo -->
        <h4 class="login-box-msg">Для восстановления доступа введите, пожалуйста, адрес электронной почты, указанный при регистрации:</h4>
        <?php $form = ActiveForm::begin(['id' => 'form-request']); ?>
        <div class="form-group has-feedback">
            <?= $form->field($model, 'email') ?>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary btn-lg btn-block', 'name' => 'login-button']) ?></div>
        </div>
        <?php ActiveForm::end() ?>
    </div>
</div>

