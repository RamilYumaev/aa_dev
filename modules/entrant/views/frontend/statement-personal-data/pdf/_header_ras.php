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

$cpk = in_array($anketa->citizenship_id, $cpkCountryArray)
    || $anketa->category_id == CategoryStruct::COMPATRIOT_COMPETITION;
if ($cpk) {

   // $actual = AddressHelper::actual($user_id);
    $reg = AddressHelper::registrationResidence($user_id);
}
?>
    <div class="bg-gray h-20"></div>
    <p align="center"><strong>СОГЛАСИЕ НА ОБРАБОТКУ ПЕРСОНАЛЬНЫХ ДАННЫХ, РАЗРЕШЕННЫХ СУБЪЕКТОМ ПЕРСОНАЛЬНЫХ ДАННЫХ ДЛЯ РАСПРОСТРАНЕНИЯ</strong></p>
    <p>В соответствии со ст. 9 Федерального закона от 27.07.2006 № 152-ФЗ "О персональных данных",</p>
    
    <table width="100%">
        <tr>
            <td><strong>Субъект персональных данных</strong> (абитуриент/обучающийся):</td>
            <td width="50%"
                class="bb text-center"><?= $profile['last_name'] ?> <?= $profile['first_name'] ?> <?= $profile['patronymic'] ? " "
                    . $profile['patronymic'] : "" ?></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="1" class="v-align-top text-center fs-7"><i>(фамилия, имя, отчество, дата рождения
                    поступающего)</i></td>
            <td></td>
        </tr>
    </table>
    <table width="100%">
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
<?php if ($cpk) : ?>
    <table width="100%">
        <tr>
            <td width="32%">проживающий(ая) по адресу:</td>
            <td width="68%" colspan="4" class="bb text-center"><?= $reg['full'] ?></td>
        </tr>
    </table>

<?php endif; ?>
    <table width="100%">
        <tr>
            <td width="20%">телефон:</td>
            <td width="30%" colspan="4" class="bb text-center"><?= $profile['phone'] ?></td>
            <td width="5%"></td>
            <td width="15%">e-mail:</td>
            <td width="30%" colspan="4" class="bb text-center"><?= $profile['email']?></td>
        </tr>
    </table>
    <!-- <table width="50%">
        <tr>
            
        </tr>
    </table> -->


<?php if ($passport['age'] < 18): ?>
    <p>
    ФИО законного представителя субъекта персональных данных (заполняется при получении согласия от представителя субъекта персональных данных)
    </p>
    <br>

    <table width="100%">
        <tr>
            <td class="bb h-20"></td>
        </tr>
        <tr>
            <td class="bb h-30"></td>
        </tr>
        <tr>
            <td class="bb h-30"></td>
        </tr>
        <tr>
            <td class="fs-7 text-center"><i>(номер основного документа, удостоверяющего его личность, сведения о дате выдачи указанного документа и выдавшем его органе, реквизиты доверенности или иного документа, подтверждающего полномочия этого представителя)</i>
            </td>
        </tr>
    </table>
<?php endif; ?>