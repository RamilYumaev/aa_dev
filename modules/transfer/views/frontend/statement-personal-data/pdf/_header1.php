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


   // $actual = AddressHelper::actual($user_id);
    $reg = AddressHelper::registrationResidence($user_id);
?>
    <div class="bg-gray h-20"></div>
    <p align="center"><strong>СОГЛАСИЕ НА ОБРАБОТКУ ПЕРСОНАЛЬНЫХ ДАННЫХ</strong></p>

    <table width="100%">
        <tr>
            <td class="text-right">Я,</td>
            <td colspan="2" width="99%"
                class="bb text-center"><?= $profile['last_name'] ?> <?= $profile['first_name'] ?> <?= $profile['patronymic'] ? " "
                    . $profile['patronymic'] : "" ?></td>
            <td class="text-right" colspan="2">(далее – Субъект)</td>
        </tr>
        <tr>
            <td></td>
            <td colspan="3" class="v-align-top text-center fs-7"><i>(фамилия, имя, отчество, дата рождения
                    поступающего)</i></td>
            <td></td>
        </tr>
        <tr>
            <td class="bb"><?= $passport['date_of_birth'] ?></td>
            <td class="text-center"> года рождения, паспорт/иной документ удостоверяющий личность серия</td>
            <td class="bb" width="5%"><?= $passport['series'] ?></td>
            <td width="7%">номер</td>
            <td class="bb" width="11%"><?= $passport['number'] ?></td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="17%"> кем и когда выдан</td>
            <td width="83%" colspan="4" class="bb text-center"><?= $passport['authority'] ?> <?= $passport['date_of_issue'] ?></td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="32%">зарегистрированный(ая) по адресу:</td>
            <td width="68%" colspan="4" class="bb text-center"><?= $reg['full'] ?></td>
        </tr>
    </table>


<?php if ($passport['age'] < 18): ?>
    <table class="mt-30" width="100%">
        <tr>
            <td width="10px">Я,</td>
            <td class="bb"></td>
        </tr>
        <tr>
            <td></td>
            <td class="text-center fs-7 h-30"><i>(фамилия, имя, отчество, дата рождения законного представителя)</i>
            </td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="86%" class="bb h-30"></td>
            <td width="14%">года рождения,</td>
        </tr>
    </table>

    <table width="100%">
        <tr>
            <td width="50%" class="h-30">паспорт/иной документ удостоверяющий личность серия</td>
            <td class="bb"></td>
            <td width="7%">номер</td>
            <td class="bb" width="15%"></td>
            <td width="19%">, кем и когда выдан</td>
            <td class="bb"></td>
        </tr>
        <tr>
            <td colspan="6" class="bb h-30"></td>
        </tr>
    </table>

    <table width="100%">
        <tr>
            <td class="h-30" width="32%">зарегистрированный(ая) по адресу:</td>
            <td width="68%" class="bb"></td>
        </tr>
        <tr>
            <td colspan="2" class="bb h-30"></td>
        </tr>
    </table>

    <table width="100%">
        <tr>
            <td width="32%" class="h-30">являясь законным представителем</td>
            <td class="bb"></td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td class="bb h-30" width="35%"></td>
            <td width="17%">(далее – Субъект)</td>
            <td class="bb" width="34%"></td>
            <td>года рождения,</td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="50%" class="h-30">паспорт/иной документ удостоверяющий личность серия</td>
            <td class="bb"></td>
            <td width="7%">номер</td>
            <td class="bb" width="15%"></td>
            <td width="19%">, кем и когда выдан</td>
            <td class="bb"></td>
        </tr>
        <tr>
            <td colspan="6" class="bb h-30"></td>
        </tr>
    </table>

    <table width="100%">
        <tr>
            <td class="h-30" width="32%">зарегистрированного(ой) по адресу:</td>
            <td width="68%" class="bb"></td>
        </tr>
        <tr>
            <td colspan="2" class="bb h-30"></td>
        </tr>
    </table>

    <table width="100%">
        <tr>
            <td width="14%" class="h-30">на основании</td>
            <td class="bb"></td>
        </tr>
        <tr>
            <td></td>
            <td class="fs-7 text-center"><i>(документ, подтверждающий, что Субъект является законным представителем
                    поступающего)</i>
            </td>
        </tr>
    </table>
<?php endif; ?>