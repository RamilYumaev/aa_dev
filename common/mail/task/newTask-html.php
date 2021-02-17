<?php

/* @var $this yii\web\View */

/* @var $this yii\web\View */
/* @var $profile olympic\models\auth\Profiles */
/* @var $text string */
?>
<?= $profile->withBestRegard() ?>, <?= $profile->firstNameAndPatronymic() ?>!
<div>
    <p><?= $text ?></p>
    <p>Письмо сгенерировано автоматически и отвечать на него не нужно.</p>
    Сайт fok.sdo.mpgu.org<br/>
    Сайт университета: mpgu.su</p>
</div>