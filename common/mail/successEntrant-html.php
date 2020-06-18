<?php

/* @var $this yii\web\View */

/* @var $this yii\web\View */
/* @var $profile olympic\models\auth\Profiles */
/* @var $text string */
?>
<?= $profile->withBestRegard() ?>, <?= $profile->fio ?>!
<div>
    <p>Приемная комиссия МПГУ рада сообщить Вам, что <?= $text ?>.</p>
    <p>Письмо сгенерировано автоматически и отвечать на него не нужно.</p>
    <p>С уважением, <br/>
    приемная комиссия МПГУ<br/>
    Сайт sdo.mpgu.org<br/>
    Сайт университета: mpgu.su</p>
</div>