<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\auth\models\User */
/* @var $dod int */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/confirm/dod', 'token' => $user->verification_token,
    'dod_id' => $dod]);
?>
<div class="verify-email">
    <p>Здравствуйте!</p>

    <p>Для подтверждения электронной почты, пожалуйста, пройдите по ссылке ниже:</p>

    <p><?= Html::a(Html::encode($verifyLink), $verifyLink) ?></p>
</div>
