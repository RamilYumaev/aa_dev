<?php

/* @var $this yii\web\View */

/* @var $this yii\web\View */
/* @var $user common\auth\models\User */
/* @var $profile olympic\models\auth\Profiles */
/* @var $string string */
$profile = $user->profiles;
?>
Уважаемый абитуриент!
Создан Личный кабинет.
Логин: <?= $user->email ?>
Пароль: <?= $string ?>
Письмо сгенерировано автоматически и отвечать на него не нужно.
Личный кабинет доступен по ссылке: https://sdo.mpgu.org/account/login
С уважением,
приемная комиссия МПГУ
Сайт sdo.mpgu.org
Сайт университета: mpgu.su

