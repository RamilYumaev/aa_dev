<?php

/* @var $this yii\web\View */

/* @var $this yii\web\View */
/* @var $user common\auth\models\User */
/* @var $profile olympic\models\auth\Profiles */
/* @var $string string */
$profile = $user->profiles;
?>
<?= $profile->withBestRegard() ?>, <?= $profile->firstNameAndPatronymic() ?>!
<div>
    <p>Создан Личный кабинет</p>
    <p>Логин: <?= $user->email ?></p>
    <p>Пароль: <?= $string ?></p>
    <p>Личный кабинет доступен по ссылке: <a href="https://sdo.mpgu.org/account/login">https://sdo.mpgu.org/account/login</a></p>
    <p>Письмо сгенерировано автоматически и отвечать на него не нужно.</p>
    <p>С уважением, <br/>
    приемная комиссия МПГУ<br/>
    Сайт sdo.mpgu.org<br/>
    Сайт университета: mpgu.su</p>
</div>