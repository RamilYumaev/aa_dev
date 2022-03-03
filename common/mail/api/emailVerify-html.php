<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $user common\auth\models\User */

$verifyLink =  Url::to('@static/sign-up/confirm?token='. $user->verification_token, true);
?>
<div class="verify-email">
    <p>Здравствуйте!</p>

    <p>Для подтверждения электронной почты, пожалуйста, пройдите по ссылке ниже:</p>

    <p><?= Html::a(Html::encode($verifyLink), $verifyLink) ?></p>
</div>
