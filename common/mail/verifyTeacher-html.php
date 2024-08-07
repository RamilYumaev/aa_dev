<?php

use yii\helpers\Html;
use  yii\helpers\Url;
use olympic\helpers\auth\ProfileHelper;
use dictionary\helpers\DictSchoolsHelper;

/* @var $this yii\web\View */
/* @var $teacher teacher\models\UserTeacherJob */
/* @var $olympic int */

$verifyLink = Url::to('@frontendInfo/auth/confirm/teacher?hash='.$teacher->hash,  true);
?>
<div class="verify-email">
    <p>Уважаемые коллеги! </p>
    <p>Оргкомитет олимпиад и конкурсов Московского педагогического государственного университета просит подтвердить информацию о том,
    что <?= ProfileHelper::profileFullName($teacher->user_id)?> работает в <?= DictSchoolsHelper::schoolName($teacher->school_id)?> учителем. Данное подтверждение нам необходимо для выдачи электронного благодарственного письма!
    Для автоматического подтверждения просим пройти по данной ссылке <?= Html::a(Html::encode($verifyLink), $verifyLink) ?></p>
    <p>В противном случае просим проигнорировать данное сообщение. </p>

    <p>Письмо сгенерировано автоматически и отвечать на него не нужно.</p>

    <p>С уважением и с благодарностью за сотрудничество,<br />
    Оргкомитет олимпиад и конкурсов МПГУ<br />
    Сайт олимпиад sdo.mpgu.org/olimpiads<br />
    Сайт университета: mpgu.su<br />
        Телефон для справок: 8(499)702-41-41</p>

</div>
