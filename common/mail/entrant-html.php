<?php

/* @var $this yii\web\View */

/* @var $this yii\web\View */
/* @var $profile olympic\models\auth\Profiles */
/* @var $text string */
/* @var $url string */

use yii\helpers\Html; ?>
<?= $profile->withBestRegard() ?>, <?= $profile->firstNameAndPatronymic() ?>!
<div>
    <?= $text ?>: <?= Html::a(Html::encode($url), $url) ?>.
    <p>Письмо сгенерировано автоматически и отвечать на него не нужно.</p>
    <p>С уважением, <br/>
    приемная комиссия МПГУ<br/>
    Сайт sdo.mpgu.org<br/>
    Сайт университета: mpgu.su</p>
</div>