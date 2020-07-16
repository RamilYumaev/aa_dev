<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $profile olympic\models\auth\Profiles */
/* @var $text string */
$url = Url::to('@frontendInfo/abiturient/post-document/agreement-contract', true); ?>
<?= $profile->withBestRegard() ?>, <?= $profile->firstNameAndPatronymic ?>!
<div>
    <p>Приемная комиссия МПГУ сообщает Вам, что <?= $text ?>.</p>
    <p>Для ознакомления, пожалуйста, войдите в свой личный кабинет по ссылке: : <?= Html::a(Html::encode($url), $url) ?></p>
    <p>Письмо сгенерировано автоматически и отвечать на него не нужно.</p>
    <p>С уважением, <br/>
    приемная комиссия МПГУ<br/>
    Сайт sdo.mpgu.org<br/>
    Сайт университета: mpgu.su</p>
</div>