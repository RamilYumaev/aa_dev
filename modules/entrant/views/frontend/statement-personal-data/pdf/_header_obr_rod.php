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
    <p align="center"><strong>СОГЛАСИЕ НА ОБРАБОТКУ ПЕРСОНАЛЬНЫХ ДАННЫХ</strong></p>
    <p>В соответствии со ст. 9 Федерального закона от 27.07.2006 № 152-ФЗ "О персональных данных",</p>
    
    <table width="100%">
        <tr>
            <td><strong>Субъект персональных данных</strong> (родитель, законный представитель обучающегося, абитуриента):</td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td class="bb text-center h-20"></td>
        </tr>
        <tr>
            
            <td colspan="1" class="v-align-top text-center fs-7"><i>(фамилия, имя, отчество, законного представителя обучающегося, абитуриента)</i></td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td class="bb h-20"></td>
            <td class="text-center"> года рождения, паспорт/иной документ удостоверяющий личность серия</td>
            <td class="bb h-20" width="5%"></td>
            <td width="7%">номер</td>
            <td class="bb h-20" width="11%"></td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="17%"> кем и когда выдан</td>
            <td width="83%" colspan="4" class="bb text-center h-20"></td>
        </tr>
    </table>
<?php if ($cpk) : ?>
    <table width="100%">
        <tr>
            <td width="32%">проживающий(ая) по адресу:</td>
            <td width="68%" colspan="4" class="bb text-center h-20"></td>
        </tr>
    </table>

<?php endif; ?>
    <table width="100%">
        <tr>
            <td width="20%">телефон:</td>
            <td width="30%" colspan="4" class="bb text-center"></td>
            <td width="5%"></td>
            <td width="15%">e-mail:</td>
            <td width="30%" colspan="4" class="bb text-center"></td>
        </tr>
    </table>


