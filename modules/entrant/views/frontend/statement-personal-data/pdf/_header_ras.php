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

$cpkCountryArray = array_merge(DictCountryHelper::TASHKENT_AGREEMENT, [DictCountryHelper::RUSSIA]);

$cpk = ($anketa->category_id == CategoryStruct::GENERAL_COMPETITION && in_array($anketa->citizenship_id, $cpkCountryArray))
    || $anketa->category_id == CategoryStruct::COMPATRIOT_COMPETITION;
if ($cpk) {

   // $actual = AddressHelper::actual($user_id);
    $reg = AddressHelper::registrationResidence($user_id);
}
?>
    <div class="bg-gray h-20"></div>
    <p align="center"><strong>СОГЛАСИЕ</strong></p>
    <p align="center"><strong>на обработку персональных данных абитуриента/обучающегося разрешённых для распространения</strong></p>
    
    <table width="100%">
        <tr>
            <td>Я, </td>
            <td class="bb text-center"><?= $profile['last_name'] ?> <?= $profile['first_name'] ?> <?= $profile['patronymic'] ? " "
                    . $profile['patronymic'] : "" ?></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="1" class="v-align-top text-center fs-7"><i>(фамилия, имя, отчество (при наличии) абитуриента/обучающегося на русском языке (в русской транскрипции для иностранного гражданина и лица без гражданства)</i></td>
            <td></td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="25%">(далее - субъект персональных данных), номер телефона</td>
            <td width="25%" colspan="4" class="bb text-center"><?= $profile['phone'] ?></td>
            <td width="5%"></td>
            <td width="7%">e-mail:</td>
            <td width="38%" colspan="4" class="bb text-center"><?= $profile['email']?></td>
        </tr>
    </table>