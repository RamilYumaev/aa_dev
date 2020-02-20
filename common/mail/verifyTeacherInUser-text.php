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

Оргкомитет олимпиад и конкурсов Московского педагогического государственного университета просит подтвердить информацию о том,
что  <?= $userOlympic->getFullNameUserOrTeacher($teacher_id)?>  является Вашим учителем и принимал активное участие
в Вашей подготовке. Для автоматического подтверждение необходимо перейти по следующей ссылке
<?= $verifyLink ?> .

В противном случае просим проигнорировать данное сообщение.
Письмо сгенерировано автоматически и отвечать на него не нужно.

С уважением и с благодарностью за сотрудничество,
Оргкомитет олимпиад и конкурсов МПГУ
Сайт олимпиад sdo.mpgu.org/olimpiads
Сайт университета: mpgu.su
Телефон для справок: 8(499)702-41-41

