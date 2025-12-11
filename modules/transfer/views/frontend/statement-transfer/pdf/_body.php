<?php
/* @var $this yii\web\View */
/* @var $gender string */
/* @var $profile array */
/* @var $passport array */
/* @var $education array */
use modules\transfer\models\TransferMpgu;
/* @var $name \common\auth\models\DeclinationFio */
/* @var $statement \modules\transfer\models\StatementTransfer */
/* @var $statementConsent modules\entrant\models\StatementConsentCg */
$nameFull = $profile['last_name'] . " " . $profile['first_name'] . " ".$profile['patronymic'];
$type = $statement->transferMpgu->type;
 ?>
<div class="mt-25">
    <p align="center" class="fs-15"><strong>ЗАЯВЛЕНИЕ</p>
    <div class="row ">
        <?php if($type == TransferMpgu::IN_MPGU || $type == TransferMpgu::IN_MPGU_GIA): ?>
            <?= $this->render('type/in_mpsu',['statement' => $statement]) ?>
        <?php elseif($type  == TransferMpgu::IN_INSIDE_MPGU): ?>
            <?= $this->render('type/in_inside_mpsu',['statement' => $statement]) ?>
        <?php elseif($type == TransferMpgu::INSIDE_MPGU): ?>
            <?= $this->render('type/inside_mpsu',['statement' => $statement]) ?>
        <?php else: ?>
            <?= $this->render('type/edu_inside_mpsu',['statement' => $statement]) ?>
        <?php endif; ?>
    </div>
</div>
