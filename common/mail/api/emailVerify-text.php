<?php
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $user common\auth\models\User */

$verifyLink = Url::to('@static/sign-up/confirm?token='. $user->verification_token, true); ?>
Здравствуйте!

Для подтверждения электронной почты, пожалуйста, пройдите по ссылке ниже:
<?= $verifyLink ?>
