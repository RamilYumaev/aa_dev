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
        <p class="login-box-msg"></p>
        <?php $form = ActiveForm::begin(['id' => 'form-edit-user']); ?>
        <td class="form-group has-feedback">
            <?= $form->field($model, 'username') ?>
            <?php if ($user->status == UserHelper::STATUS_WAIT): ?>
                <table width="100%">
                    <tr>
                        <td width="60%">
                            <?= $form->field($model, 'email') ?>
                        </td>
                        <td class="text-right fs-15">
                            <?= Html::a('Подтвердить почту', ['sign-up/confirm-user']) ?>
                        </td>
                    </tr>
                </table>

            <?php else: ?>
            <div class="m-10">
            <?= "Почта ". $user->email . " подтверждена." ?>
            </div>
            <?php endif;?>
            <div class="row">
                <div class="col-md-2 col-md-offset-4">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary btn-lg', 'name' => 'login-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end() ?>
    </div>
</div>
