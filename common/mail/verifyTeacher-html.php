<?php

use yii\helpers\Html;
use  yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $teacher teacher\models\UserTeacherJob */
/* @var $olympic int */

$verifyLink = Url::to(['@frontendInfo/auth/confirm/teacher', 'hash' => $teacher->hash],  true);
?>
<div class="verify-email">
    <p>Здравствуйте!</p>

    <p>Для подтвеждения электронной почты, пожалуйста, пройдите по ссылке ниже:</p>

    <p><?= Html::a(Html::encode($verifyLink), $verifyLink) ?></p>
</div>
