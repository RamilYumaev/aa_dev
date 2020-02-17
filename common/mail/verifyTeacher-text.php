<?php

use  yii\helpers\Url;
use olympic\helpers\auth\ProfileHelper;
use dictionary\helpers\DictSchoolsHelper;

/* @var $this yii\web\View */
/* @var $teacher teacher\models\UserTeacherJob */
/* @var $olympic int */

$verifyLink = Url::to('@frontendInfo/auth/confirm/teacher?hash='.$teacher->hash,  true);
?>
Уважаемые коллеги!
Оргкомитет олимпиад и конкурсов Московского педагогического государственного университета просит подтвердить информацию о том,
что <?= ProfileHelper::profileFullName($teacher->user_id)?> работает в <?= DictSchoolsHelper::schoolName($teacher->school_id)?> учителем. Данное подтверждение нам необходимо для выдачи электронного благодарственного письма!
Для автоматического подтверждения просим пройти по данной ссылке <?= $verifyLink ?>
В противном случае просим проигнорировать данное сообщение.

Письмо сгенерировано автоматически и отвечать на него не нужно.

С уважением и с благодарностью за сотрудничество,
Оргкомитет олимпиад и конкурсов МПГУ
Сайт олимпиад sdo.mpgu.org/olimpiads
Сайт университета: mpgu.su
Телефон для справок: 8(499)702-41-41

