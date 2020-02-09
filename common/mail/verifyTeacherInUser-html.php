<?php

use yii\helpers\Html;
use yii\helpers\Url;
use olympic\helpers\auth\ProfileHelper;

/* @var $this yii\web\View */
/* @var $userOlympic olympic\models\UserOlimpiads */
/* @var $hash string */
/* @var $teacher_id integer */

$verifyLink = Url::to(['@frontendInfo/auth/confirm/teacher-user', 'hash' => $hash],  true);
?>
<div class="verify-email">
    <p>Здравствуйте, <?= ProfileHelper::profileName($userOlympic->user_id)?>! </p>
    <p>На портале олимпиад МПГУ <?= Html::a(Html::encode($verifyLink), $verifyLink) ?> (ссылка для подтвержедения)
    <?= $userOlympic->getFullNameUserOrTeacher($teacher_id)?> указал, что является Вашим учителем.
    казанная им учебная организация называется «<?= $userOlympic->getSchoolUser() ?>».
    Если данные указаны не верно, то сообщите, пожалуйста, нам об этом по электронной почте или по номеру телефона +7(499)702-41-41.</p>
    <p>С уважением, оргкомитет олимпиад МПГУ</p>
</div>
