<?php

/* @var $this yii\web\View */
/* @var $user common\auth\models\User */
/* @var $olympic int */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/confirm/index', 'token' => $user->verification_token,
    'olympic_id' => $olympic]);
?>
Здравствуйте!

Для подтверждения электронной почты, пожалуйста, пройдите по ссылке ниже:
<?= $verifyLink ?>
