<?php

use  yii\helpers\Url;
use olympic\helpers\auth\ProfileHelper;

/* @var $this yii\web\View */
/* @var $userOlympic olympic\models\UserOlimpiads */
/* @var $hash string */
/* @var $teacher_id integer */

$verifyLink = Url::to('@frontendInfo/auth/confirm/teacher-user?hash='.$hash,  true);
?>

Уважаемый(-ая), <?= ProfileHelper::profileName($userOlympic->user_id)?>!

 Оргкомитет олимпиад и конкурсов Московского педагогического государственного университета сообщает о том,
    что  на имя <?= $userOlympic->getFullNameUserOrTeacher($teacher_id)?>  сгенерировано автоматическое благодарственное письмо за активное участие в
    Вашей подготовке в олимпиаде/конкурсе <?= $userOlympic->olympicAndYear ?>.
Если информация не соответствует действительности, то просьба сообщить об этом в ответном письме. Подтверждать благодарственное письмо не нужно!

С уважением и с благодарностью за сотрудничество,
Оргкомитет олимпиад и конкурсов МПГУ
Сайт олимпиад sdo.mpgu.org/olimpiads
Сайт университета: mpgu.su
Телефон для справок: 8(499)702-41-41

