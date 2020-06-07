<?php
/* @var $this yii\web\View */

use modules\entrant\helpers\PassportDataHelper;
use olympic\helpers\auth\ProfileHelper;

/* @var $agreement modules\entrant\models\StatementAgreementContractCg */
/* @var $legal modules\entrant\models\LegalEntity */

$profile = ProfileHelper::dataArray($agreement->statementCg->statement->user_id);
$passport = PassportDataHelper::dataArray($agreement->statementCg->statement->user_id);
$legal = $agreement->legal;
$legal->bank;
$legal->ogrn;
$legal->address;
$legal->name;
$legal->postcode;
$legal->phone;
$legal->inn;


