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
    $fio_payer = $profile['last_name'] . " ". $profile['first_name']." ". $profile['patronymic'];
    $address_payer = $reg['full'];
}elseif($receipt->contractCg->typePersonal()) {
    $fio_payer = $receipt->contractCg->personal->fio;
    $address_payer = $receipt->contractCg->personal->fio;
}else{
    $fio_payer = $receipt->contractCg->legal->fio;
    $address_payer = $receipt->contractCg->legal->fio;
}
$cost =  $receipt->contractCg->statementCg->cg->education_year_cost;
$receiptCost = ReceiptHelper::costDefault($cost, ReceiptHelper::listSep()[$receipt->period]);

?>
<div class="fs-10">
<p><strong>ВНИМАНИЮ СТУДЕНТОВ, ОБУЧАЮЩИХСЯ НА ДОГОВОРНОЙ ОСНОВЕ!</strong><br/>
    <u>С 6 февраля 2017 года</u> в МПГУ изменяются <u>банковские реквизиты!</u><br/>
    <strong>НОВЫЕ БАНКОВСКИЕ РЕКВИЗИТЫ</strong> (для платежей с 06.02.2017):</p>
<p class="mt-10">ИНН 7704077771<br/>
КПП 770401001</p>
УФК по г. Москве (МПГУ л/с 20736У53790)<br/>
ГУ Банка России по ЦФО<br/>
БИК 044525000<br/>
р/с 40501810845252000079<br/>
ОКТМО  45383000<br/>
КБК 00000000000000000130 - за оказание платных услуг</p>

<p><strong>ОПЛАТИТЬ ОБУЧЕНИЕ</strong> в МПГУ без взимания комиссионного сбора Вы можете в любом отделении ПАО «Сбербанк России» и ПАО
    «Банк ВТБ» в г. Москве и Московской области</p>


<p class="mt-10">Квитанция для оплаты обучения с 06.02.2017:</p>
</div>
<div class="doted-line mb-30"></div>


<table width="100%" class="fs-13" cellspacing="0">
    <tr><td rowspan="8" class="text-center br-3" width="23%"><strong>Извещение</strong></td>
        <td colspan="5" class="text-center bb" ><strong><i>УФК по г. Москве (МПГУ л/с 20736У53790)</i></strong></td></tr>
    <tr><td class="fs-10 text-center" colspan="5">(наименование получателя платежа)</td></tr>
    <tr><td colspan="3" class="text-center bb"><strong><i>ИНН  7704077771 КПП  770401001</i></strong></td>
        <td class="text-center bb" colspan="2"><strong><i>р/с  40501810845252000079</i></strong></td></tr>
    <tr><td colspan="3" class="text-center fs-10">(ИНН/КПП получателя)</td>
        <td colspan="2" class="text-center fs-10">(№ счета получателя платежа)</td></tr>
    <tr><td colspan="3" class="text-center bb"><strong><i>ГУ Банка России по ЦФО</td>
        <td class="text-center bb"><strong><i>БИК 044525000</i></strong></td>
        <td class="text-center bb"><strong><i>ОКТМО 45383000</i></strong></td></tr>
    <tr><td class="text-center fs-10" colspan="5">(наименование банка получателя платежа)</td></tr>
    <tr><td class="text-center bb" colspan="5"><strong><i>КБК 00000000000000000130  - за оказание платных услуг</i></strong>
        </td></tr>
    <tr><td colspan="3" class="text-center bb h-30 v-align-bottom"><strong><i></i>
                </strong></strong></td>
        <td class="text-center bb v-align-bottom"><strong><i>№<?=$number?></i></strong>
        </td><td class="text-center bb v-align-bottom"><strong><i>от</i></strong></td><td></td><td></td></tr>
    <tr><td rowspan="7" class="text-center br-3">Кассир</td>
        <td colspan="3" class="text-center fs-10">(ФИО плательщика)</td>
        <td colspan="2" class="text-center fs-10">(по договору)</td></tr>
    <tr><td colspan="5" class="bb h-30"></td></tr>
    <tr><td colspan="5" class="text-center fs-10">(адрес плательщика)</td></tr>
    <tr><td colspan="2" class="bb text-center v-align-bottom"><strong><i><?=$fio_payer?></i></strong></td>
        <td class="bb text-center" colspan="2"><strong><i><?=$faculty?></i></strong></td>
        <td class="bb text-center v-align-bottom"><strong><i>1 1</i></strong></td></tr>
    <tr><td colspan="2" class="text-center fs-10">(ФИО студента)</td>
        <td colspan="2" class="text-center fs-10">факультет</td>
        <td class="text-center fs-10">курс семестр</td></tr>
    <tr><td colspan="2" class="text-right h-30 fs-10 v-align-bottom">Сумма платежа</td>
        <td class="bb text-center" width="20%"><?=$receiptCost?></td>
        <td colspan="2" class="text-left v-align-bottom">руб.</td></tr>
    <tr><td class="text-right fs-10 h-30 v-align-bottom">Дата</td>
        <td class="bb"></td>
        <td></td>
        <td class="text-right fs-10  v-align-bottom">Подпись плательщика</td>
        <td class="bb"></td><td></td></tr>
    <tr><td class="br-3 bb-3"></td><td colspan="5" class="bb-3"></td></tr>


    <tr><td rowspan="8" class="text-center br-3 v-align-bottom" width="23%"><strong>Квитанция</strong></td>
        <td colspan="5" class="text-center bb" ><strong><i>УФК по г. Москве (МПГУ л/с 20736У53790)</i></strong></td></tr>
    <tr><td class="fs-10 text-center" colspan="5">(наименование получателя платежа)</td></tr>
    <tr><td colspan="3" class="text-center bb"><strong><i>ИНН  7704077771 КПП  770401001</i></strong></td>
        <td class="text-center bb" colspan="2"><strong><i>р/с  40501810845252000079</i></strong></td></tr>
    <tr><td colspan="3" class="text-center fs-10">(ИНН/КПП получателя)</td>
        <td colspan="2" class="text-center fs-10">(№ счета получателя платежа)</td></tr>
    <tr><td colspan="3" class="text-center bb"><strong><i>ГУ Банка России по ЦФО</td>
        <td class="text-center bb"><strong><i>БИК 044525000</i></strong></td>
        <td class="text-center bb"><strong><i>ОКТМО 45383000</i></strong></td></tr>
    <tr><td class="text-center fs-10" colspan="5">(наименование банка получателя платежа)</td></tr>
    <tr><td class="text-center bb" colspan="5"><strong><i>КБК 00000000000000000130  - за оказание платных услуг</i></strong>
        </td></tr>
    <tr><td colspan="3" class="text-center bb h-30 v-align-bottom"><strong><i></i>
            </strong></strong></td>
        <td class="text-center bb v-align-bottom"><strong><i>№<?=$number?></i></strong>
        </td><td class="text-center bb v-align-bottom"><strong><i>от</i></strong></td><td></td><td></td></tr>
    <tr><td rowspan="7" class="text-center br-3">Кассир</td>
        <td colspan="3" class="text-center fs-10">(ФИО плательщика)</td>
        <td colspan="2" class="text-center fs-10">(по договору)</td></tr>
    <tr><td colspan="5" class="bb h-30"></td></tr>
    <tr><td colspan="5" class="text-center fs-10">(адрес плательщика)</td></tr>
    <tr><td colspan="2" class="bb text-center v-align-bottom"><strong><i><?=$fio_payer?></i></strong></td>
        <td class="bb text-center" colspan="2"><strong><i><?=$faculty?></i></strong></td>
        <td class="bb text-center v-align-bottom"><strong><i>1 1</i></strong></td></tr>
    <tr><td colspan="2" class="text-center fs-10">(ФИО студента)</td>
        <td colspan="2" class="text-center fs-10">факультет</td>
        <td class="text-center fs-10">курс семестр</td></tr>
    <tr><td colspan="2" class="text-right h-30 fs-10 v-align-bottom">Сумма платежа</td>
        <td class="bb text-center" width="20%"><?=$receiptCost?></td>
        <td colspan="2" class="text-left v-align-bottom">руб.</td></tr>
    <tr><td class="text-right fs-10 h-30 v-align-bottom">Дата</td>
        <td class="bb"></td>
        <td></td>
        <td class="text-right fs-10  v-align-bottom">Подпись плательщика</td>
        <td class="bb"></td><td></td></tr>
    <tr><td class="br-3 bb"></td><td colspan="5" class="bb"></td></tr>

</table>



