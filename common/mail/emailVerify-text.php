<?php

/* @var $this yii\web\View */
/* @var $user common\auth\models\User */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['sign-up/confirm', 'token' => $user->verification_token]);
?>
Здравствуйте!

Для подтверждения электронной почты, пожалуйста, пройдите по ссылке ниже:
<?= $verifyLink ?>
