<?php
/* @var $this yii\web\View */

use modules\entrant\helpers\AnketaHelper;
use olympic\helpers\auth\ProfileHelper;
use modules\entrant\helpers\PassportDataHelper;

/* @var $statementPd modules\entrant\models\StatementConsentPersonalData */
/* @var $anketa modules\entrant\models\Anketa */


$profile = ProfileHelper::dataArray($statementPd->user_id);
$userAnketa = $statementPd->anketa;

$passport = PassportDataHelper::dataArray($statementPd->user_id);

?>


<?php if ($passport['age'] > 17): ?>
<div style="page-break-after: always;">
<?= $this->render("_header_obr", ['profile' => $profile, 'user_id' => $statementPd->user_id, 'anketa' => $userAnketa]) ?>
<?= $this->render("_body_obr", ['statementPd' => $statementPd, 'profile' => $profile]) ?>
</div>
<div style="page-break-after: always;">
<?= $this->render("_footer_obr", ['statementPd' => $statementPd, 'profile' => $profile]) ?>
</div>
<?= $this->render("_header_ras", ['profile' => $profile, 'user_id' => $statementPd->user_id, 'anketa' => $userAnketa]) ?>
<?= $this->render("_body_ras", ['statementPd' => $statementPd, 'profile' => $profile]) ?>
<?= $this->render("_footer_ras", ['statementPd' => $statementPd, 'profile' => $profile]) ?>
<?php endif; ?>


<?php if ($passport['age'] < 18): ?>
    <div style="page-break-after: always;">
    <?= $this->render("_header_obr", ['profile' => $profile, 'user_id' => $statementPd->user_id, 'anketa' => $userAnketa]) ?>
    <?= $this->render("_body_obr", ['statementPd' => $statementPd, 'profile' => $profile]) ?>
    <?= $this->render("_footer_obr", ['statementPd' => $statementPd, 'profile' => $profile]) ?>
    </div>
    <div style="page-break-after: always;">
    <?= $this->render("_header_ras", ['profile' => $profile, 'user_id' => $statementPd->user_id, 'anketa' => $userAnketa]) ?>
    <?= $this->render("_body_ras", ['statementPd' => $statementPd, 'profile' => $profile]) ?>
    <?= $this->render("_footer_ras", ['statementPd' => $statementPd, 'profile' => $profile]) ?>
    </div>
    <div style="page-break-after: always;">
    <?= $this->render("_header_ras_rod", ['profile' => $profile, 'user_id' => $statementPd->user_id, 'anketa' => $userAnketa]) ?>
    <?= $this->render("_body_ras_rod", ['statementPd' => $statementPd, 'profile' => $profile]) ?>
    </div>
    <div style="page-break-after: always;">
    <?= $this->render("_footer_ras_rod", ['statementPd' => $statementPd, 'profile' => $profile]) ?>
    </div>
    <?= $this->render("_header_obr_rod", ['profile' => $profile, 'user_id' => $statementPd->user_id, 'anketa' => $userAnketa]) ?>
    <?= $this->render("_body_obr_rod", ['statementPd' => $statementPd, 'profile' => $profile]) ?>
    <?= $this->render("_footer_obr_rod", ['statementPd' => $statementPd, 'profile' => $profile]) ?>
    
    
    
<?php endif; ?>
