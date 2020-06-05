<?php
/* @var $this yii\web\View */

use modules\entrant\helpers\AnketaHelper;
use modules\entrant\helpers\PassportDataHelper;
use olympic\helpers\auth\ProfileHelper;

/* @var $statementRejection modules\entrant\models\StatementRejection */


$profile = ProfileHelper::dataArray($statementRejection->statement->user_id);
$passport = PassportDataHelper::dataArray($statementRejection->statement->user_id);

?>
<p>Заявление №<?= $statementRejection->statement->numberStatement ?></p>
<?php foreach ($statementRejection->statement->statementCg as $statementCg) : ?>
    <?= $statementRejection->statement->speciality->codeWithName ?>
    <?= $statementRejection->statement->eduLevel ?>
    <?= $statementRejection->statement->specialRight ?>
    <?= $statementCg->cg->fullName ?>
<?php endforeach;  ?>

