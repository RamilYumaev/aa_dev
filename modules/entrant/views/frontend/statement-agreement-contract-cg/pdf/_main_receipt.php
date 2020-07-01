<?php
/* @var $this yii\web\View */

use common\auth\helpers\DeclinationFioHelper;
use modules\entrant\helpers\AddressHelper;
use modules\entrant\helpers\PassportDataHelper;
use modules\entrant\helpers\ReceiptHelper;
use olympic\helpers\auth\ProfileHelper;

/* @var $receipt modules\entrant\models\ReceiptContract */
$profile = ProfileHelper::dataArray($receipt->contractCg->statementCg->statement->user_id);
$passport = PassportDataHelper::dataArray($receipt->contractCg->statementCg->statement->user_id);
$name = DeclinationFioHelper::userDeclination($receipt->contractCg->statementCg->statement->user_id);
$cg = $receipt->contractCg->statementCg->cg;
$reg = AddressHelper::registrationResidence($receipt->contractCg->statementCg->statement->user_id);
$totalCost = $cg->education_year_cost * $cg->education_duration;

$faculty = $cg->faculty->full_name;
$number = $receipt->contractCg->number;
$fio_entrant = $profile['last_name'] . $profile['first_name'];


if($receipt->contractCg->typeEntrant()) {
    $fio_payer = $profile['last_name'] . $profile['first_name'];
    $address_payer = $reg['full'];
}elseif($receipt->contractCg->typePersonal()) {
    $fio_payer = $receipt->contractCg->personal->fio;
    $address_payer = $receipt->contractCg->personal->fio;
}else{
    $fio_payer = $receipt->contractCg->legal->fio;
    $address_payer = $receipt->contractCg->legal->fio;
}
$cost = 352555.00;
echo ReceiptHelper::cost($cost, ReceiptHelper::listSep()[$receipt->period]);



