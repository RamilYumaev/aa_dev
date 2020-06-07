<?php
/* @var $personal yii\web\View */

use modules\entrant\helpers\DateFormatHelper;
use modules\entrant\helpers\PassportDataHelper;
use olympic\helpers\auth\ProfileHelper;

/* @var $agreement modules\entrant\models\StatementAgreementContractCg */

/* @var $personal modules\entrant\models\PersonalEntity */

$profile = ProfileHelper::dataArray($agreement->statementCg->statement->user_id);
$passport = PassportDataHelper::dataArray($agreement->statementCg->statement->user_id);
$personal = $agreement->personal;
$personal->series;
$personal->number;
$personal->address;
$personal->fio;
$personal->postcode;
$personal->phone;
$personal->date_of_issue;
$personal->authority;
