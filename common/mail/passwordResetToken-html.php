<?php

use yii\helpers\Html;use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->id == "app-api" ?  Url::to('@static/reset/confirm?token='.$user->password_reset_token, true) : Yii::$app->urlManager->createAbsoluteUrl(['reset/confirm', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <p>Здравствуйте!</p>

    <p>Перейдите по ссылке ниже, чтобы сбросить пароль:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
