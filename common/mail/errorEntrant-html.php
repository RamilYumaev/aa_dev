<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $profile olympic\models\auth\Profiles */

$url =  Yii::$app->controller->id == "profiles" ? Url::to('@frontendInfo/transfer/post-document/index', true) : Url::to('@frontendInfo/abiturient/post-document/index', true); ?>
<div class="password-reset">
    <p><?= $profile->withBestRegard() ?>, <?= $profile->firstNameAndPatronymic() ?>!</p>

    <p>Сотрудники приемной комиссии МПГУ проверили Ваши данные и обнаружили некоторые ошибки.
        Для ознакомления, пожалуйста, войдите в свой личный кабинет по ссылке: <?= Html::a(Html::encode($url), $url) ?></p>
    <p>Письмо сгенерировано автоматически и отвечать на него не нужно.</p>

    <p>С уважением,<br />
        приемная комиссия МПГУ<br />
        Сайт sdo.mpgu.org<br />
        Сайт университета: mpgu.su<br />
    </p>
</div>
