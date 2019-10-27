<?php

/* @var $this yii\web\View */
/* @var $user common\auth\models\User */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/signup/confirm', 'token' => $user->verification_token]);
?>
Здравствуйте!

Перейдите по ссылке ниже, чтобы подтвердить свой адрес электронной почты:

<?= $verifyLink ?>
