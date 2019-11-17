<?php

/* @var $this yii\web\View */
/* @var $user common\auth\models\User */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/signup/confirm', 'token' => $user->verification_token]);
?>
Здравствуйте!

Для подтвеждения электронной почты, пожалуйста, пройдите по ссылке ниже:
<?= $verifyLink ?>
