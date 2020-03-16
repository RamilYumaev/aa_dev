<?php
use yii\helpers\Html;
/* @var  $dod dod\models\DateDod */
$class= 'btn btn-lg btn-bd-primary ml-10 mb-3 mb-md-0 mr-md-3';
?>
<div>

        <?php if ($dod->isDateActual()) : ?>
            <?= \dod\helpers\DateDodHelper::dodDateActual($dod,$class, false) ?>
        <?php else: ?>
             <?= \dod\helpers\DateDodHelper::dodDateNoActual($dod,$class) ?>
        <?php endif; ?>
</div>


