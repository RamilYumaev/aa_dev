<?php

/* @var $this yii\web\View */
/* @var $user common\auth\models\User */
/* @var $dod int */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/confirm/dod', 'token' => $user->verification_token,
    'dod_id' => $dod]);
?>
Здравствуйте!

Для подтверждения электронной почты, пожалуйста, пройдите по ссылке ниже:
<?= $verifyLink ?>
