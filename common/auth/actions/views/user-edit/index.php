<?php

/* @var $this yii\web\View */

/* @var $form yii\bootstrap\ActiveForm */

use common\auth\helpers\UserHelper;
use common\auth\models\User;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

\common\auth\actions\assets\LoginAsset::register($this);

$this->title = 'Настройки личного кабинета';
$this->params['breadcrumbs'][] = $this->title;

$user = User::findOne(Yii::$app->user->identity->getId());
?>
<div class="login-box">
    <div class="login-box-body">
        <?= Html::a('на главную', '/', ['class' => 'btn-lg']) ?>
        <?= \common\widgets\Alert::widget() ?>
        <div class="login-logo">
            <h3><?= $this->title ?></h3>
        </div><!-- /.login-logo -->
        <?php if ($user->status == UserHelper::STATUS_WAIT): ?>
            <p class="label label-warning fs-15">Необходимо подтвердить почту</p>
        <?php endif; ?>
        <p class="login-box-msg"></p>
        <?php $form = ActiveForm::begin(['id' => 'form-edit-user']); ?>
        <td class="form-group has-feedback">
            <?= $form->field($model, 'username') ?>
            <?php if ($user->status == UserHelper::STATUS_WAIT): ?>

                <?= $form->field($model, 'email') ?>

            <?php else: ?>
                <div class="mb-30">
                    <?= "Почта " . $user->email . " подтверждена." ?>
                </div>
            <?php endif; ?>
            <div class="row">
                <?php if ($user->status == UserHelper::STATUS_WAIT): ?>
                    <div class="col-md-8 col-md-offset-2">
                        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                        <?= Html::a('Подтвердить почту', ['sign-up/confirm-user'], ['class' => 'btn btn-success', 'name' => 'login-button']) ?>

                    </div>
                <?php else : ?>
                    <div class="col-md-12">
                        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php ActiveForm::end() ?>
    </div>
</div>
