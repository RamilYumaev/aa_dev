<?php

use  yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $teacher teacher\models\UserTeacherJob */
/* @var $olympic int */

$verifyLink = Url::to(['@frontendInfo/auth/confirm/teacher', 'hash' => $teacher->hash],  true);
?>
Здравствуйте!

Для подтвеждения электронной почты, пожалуйста, пройдите по ссылке ниже:
<?= $verifyLink ?>
