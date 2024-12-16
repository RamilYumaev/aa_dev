<?php
/* @var $this yii\web\View */

use modules\entrant\helpers\PassportDataHelper;
use modules\entrant\helpers\AddressHelper;
use \dictionary\helpers\DictCountryHelper;
use \modules\entrant\helpers\CategoryStruct;

/* @var $user_id integer */
/* @var  $profile array */
/* @var  $anketa \modules\entrant\models\Anketa */

$passport = PassportDataHelper::dataArray($user_id);
$reg = AddressHelper::registrationResidence($user_id);
?>
    <div class="bg-gray h-20"></div>
    <p align="center"><strong>СОГЛАСИЕ</strong></p>
    <p align="center"><strong>на обработку персональных данных абитуриента/обучающегося</strong></p>
    <table width="100%">
        <tr>
            <td>Я, </td>
            <td class="bb text-center"><?= $profile['last_name'] ?> <?= $profile['first_name'] ?> <?= $profile['patronymic'] ? " "
                    . $profile['patronymic'] : "" ?></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="1" class="v-align-top text-center fs-7"><i>(фамилия, имя, отчество (при наличии), <strong>абитуриента/обучающегося</strong> на русском языке (в русской транскрипции для иностранного гражданина и лица без гражданства</i></td>
            <td></td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="7%">паспорт</td>
            <td class="bb" width="15%"><?= $passport['series'] ?></td>
            <td width="5%">№</td>
            <td class="bb" width="73%"><?= $passport['number'] ?></td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="3%">выдан</td>
            <td width="75%" class="bb text-center"><?= $passport['authority'] ?></td>
            <td width="12%">дата выдачи</td>
            <td width="10%" class="bb text-center"> <?= $passport['date_of_issue'] ?></td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="20%">проживающий по адресу:</td>
            <td width="80%" colspan="4" class="bb text-center"><?= $reg['full'] ?></td>
        </tr>
    </table>