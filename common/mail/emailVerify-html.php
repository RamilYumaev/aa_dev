<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\auth\User */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/signup/confirm', 'token' => $user->verification_token]);
?>
<div class="verify-email">
    <p>Здравствуйте!</p>

    <p>Перейдите по ссылке ниже, чтобы подтвердить свой адрес электронной почты:</p>

    <p><?= Html::a(Html::encode($verifyLink), $verifyLink) ?></p>
</div>
