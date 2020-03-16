<?php

use yii\helpers\Html;

/* @var  $dod dod\models\DateDod */
/* @var  $userDod dod\models\UserDod */
$class= 'btn btn-lg btn-bd-primary ml-10 mb-3 mb-md-0 mr-md-3';
?>
<div>

        <?php if ($dod->isDateActual()) : ?>
            <?php if (!$userDod): ?>
                <?= \dod\helpers\DateDodHelper::dodDateActual($dod, $class, true) ?>
            <?php else: ?>
                <?= \dod\helpers\DateDodHelper::dodDeleteLinks($dod, $userDod, $class) ?>
            <?php endif; ?>
        <?php else: ?>
            <?= \dod\helpers\DateDodHelper::dodDateNoActual($dod,$class) ?>
        <?php endif; ?>
</div>

