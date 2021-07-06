<?php
/* @var $this yii\web\View */

use common\auth\helpers\DeclinationFioHelper;
use dictionary\helpers\DictFacultyHelper;
use modules\entrant\helpers\AddressHelper;
use modules\entrant\helpers\AnketaHelper;
use modules\entrant\helpers\PassportDataHelper;
use modules\entrant\helpers\ReceiptHelper;
use olympic\helpers\auth\ProfileHelper;

/* @var $receipt modules\entrant\models\ReceiptContract */
$dateContract = Yii::$app->formatter->asDate($receipt->contractCg->created_at, "php:d.m.Y");
$profile = ProfileHelper::dataArray($receipt->contractCg->statementCg->statement->user_id);
$passport = PassportDataHelper::dataArray($receipt->contractCg->statementCg->statement->user_id);
$name = DeclinationFioHelper::userDeclination($receipt->contractCg->statementCg->statement->user_id);
$cg = $receipt->contractCg->statementCg->cg;
$reg = AddressHelper::registrationResidence($receipt->contractCg->statementCg->statement->user_id);
$faculty = $cg->faculty->full_name;
$number = $receipt->contractCg->number;
$fio_entrant = $profile['last_name'] . " " . $profile['first_name']. " " . $profile['patronymic'];
$anketa = Yii::$app->user->identity->anketa();

if ($receipt->contractCg->typeLegal()) {
    $fio_payer = $receipt->contractCg->legal->fio;
    $address_payer = $receipt->contractCg->legal->fio;
} elseif ($receipt->contractCg->typePersonal()) {
    $fio_payer = $receipt->contractCg->personal->fio;
    $address_payer = $receipt->contractCg->personal->fio;
} else {
    $fio_payer = $profile['last_name'] . " " . $profile['first_name'] . " " . $profile['patronymic'];
    $address_payer = $reg['full'];
}
$cost = $receipt->contractCg->statementCg->cg->education_year_cost;
$discount = $cg->discount;
if ($discount) {
    $totalCost = $cost - ($cost * ($discount / 100));
} else {
    $totalCost = $cost;
}

$universityChoice = DictFacultyHelper::getKeyFacultySetting($receipt->contractCg->statementCg->cg->faculty_id);
$universityChoice = $universityChoice == DictFacultyHelper::COLLAGE ? AnketaHelper::HEAD_UNIVERSITY : $universityChoice;
$receiptCost = ReceiptHelper::costDefault($totalCost, ReceiptHelper::listSep()[$receipt->period]);
$personalAccount = ReceiptHelper::personalAccount()[$universityChoice];
$inn = ReceiptHelper::inn()[$universityChoice];
$kpp = ReceiptHelper::kpp()[$universityChoice];
$checkingAccount = ReceiptHelper::checkingAccount()[$universityChoice];
$bank = ReceiptHelper::bank()[$universityChoice];
$bik = ReceiptHelper::bik()[$universityChoice];
$oktmo = ReceiptHelper::oktmo()[$universityChoice];
$header = ReceiptHelper::header($universityChoice);

?>
<div class="fs-13">
    <?= $header ?>
    <p align="justify" style="color:#ce0834 margin:0"><strong>ВНИМАНИЕ! После оплаты скан-копию чека необходимо загрузить в Личный кабинет поступающего.
        Зачисление происходит после предоставленного подтверждения оплаты.</strong></p>
</div>
<div class="" style="font-size: 8px">
    <table width="100%" class="fs-12" cellspacing="0">
        <tr>
            <td rowspan="8" class="text-center br-3" width="15%"><strong>Извещение</strong></td>
            <td colspan="5" class="text-center bb"><strong><i><?= $personalAccount ?></i></strong></td>
        </tr>
        <tr>
            <td class=" text-center" colspan="5">(наименование получателя платежа)</td>
        </tr>
        <tr>
            <td colspan="3" class="text-center bb"><strong><i><?= $inn ?>/<?= $kpp ?></i></strong></td>
            <td class="text-center bb" colspan="2"><strong><i>казначейский счет/ЕКС <?= $checkingAccount ?></i></strong></td>
        </tr>
        <tr>
            <td colspan="3" class="text-center " style="font-size: 8px">(ИНН/КПП получателя)</td>
            <td colspan="2" class="text-center " style="font-size: 8px">(№ счета получателя платежа)</td>
        </tr>
        <tr>
            <td colspan="3" class="text-center bb" style="font-size: 11px"><strong><i><?= $bank ?></td>
            <td class="text-center bb"><strong><i>БИК <?= $bik ?></i></strong></td>
            <td class="text-center bb"><strong><i>ОКТМО <?= $oktmo ?></i></strong></td>
        </tr>
        <tr>
            <td class="text-center " style="font-size: 8px" colspan="5">(наименование банка получателя платежа)</td>
        </tr>
        <tr>
            <td class="text-center bb" colspan="5"><strong><i>КБК 00000000000000000130 - за оказание платных
                        услуг</i></strong>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="text-center bb h-30 v-align-bottom"><strong><i></i>
                </strong></strong></td>
            <td class="text-center bb v-align-bottom" colspan="2"><strong><i>№ <?= $number ?>
                        от <?= $dateContract ?></i></strong></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td rowspan="7" class="text-center br-3">Кассир</td>
            <td colspan="3" class="text-center " style="font-size: 8px">(ФИО плательщика)</td>
            <td colspan="2" class="text-center " style="font-size: 8px">(по договору)</td>
        </tr>
        <tr>
            <td colspan="5" class="bb h-30"></td>
        </tr>
        <tr>
            <td colspan="5" class="text-center " style="font-size: 8px">(адрес плательщика)</td>
        </tr>
        <tr>
            <td colspan="3" class="bb text-center v-align-bottom fs-12"><strong><i><?= $fio_entrant?></i></strong></td>
            <td class="bb text-center" colspan="1"><strong><i><?= $faculty ?></i></strong></td>
            <td class="bb text-center v-align-bottom"><strong><i>1 1</i></strong></td>
        </tr>
        <tr>
            <td colspan="3" class="text-center " style="font-size: 8px">(ФИО студента)</td>
            <td colspan="1" class="text-center " style="font-size: 8px">факультет</td>
            <td class="text-center " style="font-size: 8px">курс семестр</td>
        </tr>
        <tr>
            <td colspan="3" class="text-right h-30  v-align-bottom">Сумма платежа</td>
            <td class="bb text-center v-align-bottom" width="20%"><?= $receiptCost ?></td>
            <td colspan="1" class="text-left v-align-bottom">руб.</td>
        </tr>
        <tr>
            <td class="text-right  h-30 v-align-bottom">Дата</td>
            <td class="bb"></td>
            <td class="bb"></td>
            <td class="text-right   v-align-bottom">Подпись плательщика</td>
            <td class="bb"></td>
            <td></td>
        </tr>
        <tr>
            <td class="br-3 bb-3"></td>
            <td colspan="5" class="bb-3"></td>
        </tr>


        <tr>
            <td rowspan="8" class="text-center br-3 v-align-bottom" width="15%"><strong>Квитанция</strong></td>
            <td colspan="5" class="text-center bb"><strong><i><?= $personalAccount ?></i></strong></td>
        </tr>
        <tr>
            <td class=" text-center" colspan="5">(наименование получателя платежа)</td>
        </tr>
        <tr>
            <td colspan="3" class="text-center bb"><strong><i><?= $inn ?>/<?= $kpp ?></i></strong></td>
            <td class="text-center bb" colspan="2"><strong><i>казначейский счет <?= $checkingAccount ?></i></strong></td>
        </tr>
        <tr>
            <td colspan="3" class="text-center " style="font-size: 8px">(ИНН/КПП получателя)</td>
            <td colspan="2" class="text-center " style="font-size: 8px">(№ счета получателя платежа)</td>
        </tr>
        <tr>
            <td colspan="3" class="text-center bb" style="font-size: 11px"><strong><i><?= $bank ?></td>
            <td class="text-center bb"><strong><i>БИК <?= $bik ?></i></strong></td>
            <td class="text-center bb"><strong><i>ОКТМО <?= $oktmo ?></i></strong></td>
        </tr>
        <tr>
            <td class="text-center " style="font-size: 8px" colspan="5">(наименование банка получателя платежа)</td>
        </tr>
        <tr>
            <td class="text-center bb" colspan="5"><strong><i>КБК 00000000000000000130 - за оказание платных
                        услуг</i></strong>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="text-center bb h-30 v-align-bottom"><strong><i></i>
                </strong></strong></td>
            <td class="text-center bb v-align-bottom" colspan="2"><strong><i>№ <?= $number ?>
                        от <?= $dateContract ?></i></strong></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td rowspan="7" class="text-center br-3">Кассир</td>
            <td colspan="3" class="text-center " style="font-size: 8px">(ФИО плательщика)</td>
            <td colspan="2" class="text-center " style="font-size: 8px">(по договору)</td>
        </tr>
        <tr>
            <td colspan="5" class="bb h-30"></td>
        </tr>
        <tr>
            <td colspan="5" class="text-center " style="font-size: 8px">(адрес плательщика)</td>
        </tr>
        <tr>
            <td colspan="3" class="bb text-center v-align-bottom fs-12"><strong><i><?= $fio_entrant ?></i></strong></td>
            <td class="bb text-center" colspan="1"><strong><i><?= $faculty ?></i></strong></td>
            <td class="bb text-center v-align-bottom"><strong><i>1 1</i></strong></td>
        </tr>
        <tr>
            <td colspan="3" class="text-center " style="font-size: 8px">(ФИО студента)</td>
            <td colspan="1" class="text-center " style="font-size: 8px">факультет</td>
            <td class="text-center " style="font-size: 8px">курс семестр</td>
        </tr>
        <tr>
            <td colspan="3" class="text-right h-30 fs-12 v-align-bottom">Сумма платежа</td>
            <td class="bb text-center v-align-bottom" width="20%"><?= $receiptCost ?></td>
            <td colspan="1" class="text-left v-align-bottom">руб.</td>
        </tr>
        <tr>
            <td class="text-right  h-30 v-align-bottom">Дата</td>
            <td class="bb"></td>
            <td class="bb"></td>
            <td class="text-right   v-align-bottom">Подпись плательщика</td>
            <td class="bb"></td>
            <td></td>
        </tr>
        <tr>
            <td class="br-3 bb"></td>
            <td colspan="5" class="bb"></td>
        </tr>

    </table>



