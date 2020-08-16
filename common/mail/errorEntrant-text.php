<?php

/* @var $this yii\web\View */

/* @var $this yii\web\View */
/* @var $profile olympic\models\auth\Profiles */
use yii\helpers\Url;
$url =   Url::to('@frontendInfo/abiturient/post-document/index', true);
?>
    <?= $profile->withBestRegard() ?>, <?= $profile->firstNameAndPatronymic() ?>!

    Сотрудники приемной комиссии МПГУ проверили Ваши данные и обнаружили некоторые ошибки.
        Для ознакомления, пожалуйста, войдите в свой личный кабинет по ссылке: <?=  $url ?>
    Письмо сгенерировано автоматически и отвечать на него не нужно.

    С уважением,
        приемная комиссия МПГУ
        Сайт sdo.mpgu.org
        Сайт университета: mpgu.su

