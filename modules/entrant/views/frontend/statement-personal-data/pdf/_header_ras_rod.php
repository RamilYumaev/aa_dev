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

$cpk = $cpk = ($anketa->category_id == CategoryStruct::GENERAL_COMPETITION && in_array($anketa->citizenship_id, $cpkCountryArray))
|| $anketa->category_id == CategoryStruct::COMPATRIOT_COMPETITION;
if ($cpk) {

   // $actual = AddressHelper::actual($user_id);
    $reg = AddressHelper::registrationResidence($user_id);
}
?>
    <div class="bg-gray h-20"></div>
    <p align="center"><strong>СОГЛАСИЕ</strong></p>
    <p align="center"><strong>законного представителя на обработку персональных данных абитуриента/обучающегося, разрешённых для распространения</strong></p>
    
    <table width="100%">
        <tr>
            <td>Я, </td>
            <td class="bb text-center h-20"></td>
        </tr>
        <tr>
            <td></td>    
            <td colspan="1" class="v-align-top text-center fs-7"><i>(фамилия, имя, отчество (при наличии) родителя, законного представителя абитуриента/обучающегося на русском языке (в русской транскрипции для иностранного гражданина и лица без гражданства)</i></td>
        </tr>
    </table>

    <table width="100%">
        <tr>
            <td width="10%">телефон:</td>
            <td width="40%" colspan="4" class="bb text-center"></td>
            <td width="5%"></td>
            <td width="7%">e-mail:</td>
            <td width="38%" colspan="4" class="bb text-center"></td>
        </tr>
    </table>

<table width="100%">
        <tr>
            <td width="20%">являясь на основании</td>
            <td width="80%" class="bb text-center h-20"></td>
        </tr>
        <tr>
            <td></td>    
            <td colspan="1" class="v-align-top text-center fs-7"><i>(документ, подтверждающий полномочия законного представитечя, или иное основание)</i></td>
        </tr>
    </table>

<table width="100%">
        <tr>
            <td width="20%">законным представителем</td>
            <td width="45%" class="bb text-center h-20"></td>
            <td width="35%"> (далее - субъект персональных данных, Субъект),</td>
        </tr>
        <tr>
            <td></td>    
            <td colspan="1" class="v-align-top text-center fs-7"><i>(полное ФИО представляемого)</i></td>
            <td></td>
        </tr>
    </table>