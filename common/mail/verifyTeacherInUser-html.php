<?php

use yii\helpers\Html;
use yii\helpers\Url;
use olympic\helpers\auth\ProfileHelper;

/* @var $this yii\web\View */
/* @var $userOlympic olympic\models\UserOlimpiads */
/* @var $hash string */
/* @var $teacher_id integer */

$verifyLink = Url::to('@frontendInfo/auth/confirm/teacher-user?hash='.$hash,  true);
?>
<div class="verify-email">
    <p>Уважаемый(-ая), <?= ProfileHelper::profileName($userOlympic->user_id)?>! </p>

    <p> Оргкомитет олимпиад и конкурсов Московского педагогического государственного университета сообщает о том,
    что  на имя <?= $userOlympic->getFullNameUserOrTeacher($teacher_id)?>  сгенерировано автоматическое благодарственное письмо за активное участие в
        Вашей подготовке в олимпиаде/конкурсе <?= $userOlympic->olympicAndYear ?>.</p>
    <p>Если информация не соответствует действительности, то просьба сообщить об этом в ответном письме. Подтверждать благодарственное письмо не нужно! </p>

    <p>С уважением и с благодарностью за сотрудничество,<br />
    Оргкомитет олимпиад и конкурсов МПГУ<br />
    Сайт олимпиад sdo.mpgu.org/olimpiads<br />
    Сайт университета: mpgu.su<br />
        Телефон для справок: 8(499)702-41-41 </p>


</div>
