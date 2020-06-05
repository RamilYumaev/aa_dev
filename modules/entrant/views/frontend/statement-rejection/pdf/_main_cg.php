<?php
/* @var $this yii\web\View */

use modules\entrant\helpers\AnketaHelper;
use modules\entrant\helpers\PassportDataHelper;
use olympic\helpers\auth\ProfileHelper;

/* @var $statementCg modules\entrant\models\StatementCg */


$profile = ProfileHelper::dataArray($statementCg->statement->user_id);
$passport = PassportDataHelper::dataArray($statementCg->statement->user_id);

?>
<p>Заявление №<?= $statementCg->statement->numberStatement ?></p>

    <?= $statementCg->statement->speciality->codeWithName ?>
    <?= $statementCg->statement->eduLevel ?>
    <?= $statementCg->statement->specialRight ?>
    <?= $statementCg->cg->fullName ?>


