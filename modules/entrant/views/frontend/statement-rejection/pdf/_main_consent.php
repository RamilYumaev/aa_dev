<?php
/* @var $this yii\web\View */

use modules\entrant\helpers\AnketaHelper;
use modules\entrant\helpers\PassportDataHelper;
use olympic\helpers\auth\ProfileHelper;

/* @var $statementConsent modules\entrant\models\StatementRejectionCgConsent */


$profile = ProfileHelper::dataArray($statementConsent->statementConsentCg->statementCg->statement->user_id);
$passport = PassportDataHelper::dataArray($statementConsent->statementConsentCg->statementCg->statement->user_id);

?>
<p>Заявление №<?= $statementConsent->statementConsentCg->statementCg->statement->numberStatement ?></p>

    <?= $statementConsent->statementConsentCg->statementCg->statement->speciality->codeWithName ?>
    <?= $statementConsent->statementConsentCg->statementCg->statement->eduLevel ?>
    <?= $statementConsent->statementConsentCg->statementCg->statement->specialRight ?>
    <?= $statementConsent->statementConsentCg->statementCg->cg->fullName ?>


