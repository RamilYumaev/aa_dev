<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\auth\models\User */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['sign-up/confirm', 'token' => $user->verification_token]);
?>
<div class="verify-email">
    <p>Здравствуйте!</p>

    <p>Для подтвеждения электронной почты, пожалуйста, пройдите по ссылке ниже:</p>

    <p><?= Html::a(Html::encode($verifyLink), $verifyLink) ?></p>
</div>
