<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $profile olympic\models\auth\Profiles */
/* @var $text string */
$url = Url::to('@frontendInfo/abiturient/post-document/agreement-contract', true); ?>

<?= $profile->withBestRegard() ?>, <?= $profile->firstNameAndPatronymic() ?>!
Приемная комиссия МПГУ сообщает Вам, что <?= $text ?>.
Для ознакомления, пожалуйста, войдите в свой личный кабинет по ссылке: <?=  $url ?>
Письмо сгенерировано автоматически и отвечать на него не нужно.

С уважением,
приемная комиссия МПГУ
Сайт sdo.mpgu.org
Сайт университета: mpgu.su

