<?php
/* @var $this yii\web\View */

use modules\entrant\helpers\PassportDataHelper;
use olympic\helpers\auth\ProfileHelper;

/* @var $agreement modules\entrant\models\StatementAgreementContractCg */

$profile = ProfileHelper::dataArray($agreement->statementCg->statement->user_id);
$passport = PassportDataHelper::dataArray($agreement->statementCg->statement->user_id);


