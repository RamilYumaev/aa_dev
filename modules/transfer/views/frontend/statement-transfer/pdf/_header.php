<?php
/* @var $this yii\web\View */

use modules\entrant\helpers\PassportDataHelper;
use modules\entrant\helpers\AddressHelper;
use modules\entrant\helpers\DocumentEducationHelper;
use \olympic\helpers\auth\ProfileHelper;
use yii\helpers\Html;

/* @var $user_id integer */
/* @var  $profile array */
/* @var  $name string */
$passport = PassportDataHelper::dataArray($user_id);
$address = AddressHelper::registrationResidence($user_id);
$nameFull = $name->genitive ?? $profile['last_name'] . " " . $profile['first_name'] . " ".$profile['patronymic'];

?>
<table class="fs-15">
    <tr>
    <td width="10%"></td>
        <td width="62%"></td>
        <td>
            Ректору МПГУ<br />
            члену-корреспонденту РАО,<br />
            доктору исторических наук,<br />
            профессору А.В. Лубкову<br />
            От: <?= $nameFull?><br/>
            адрес проживания: <?= $address['full']?> <br/>
            телефон: <?= $profile['phone'] ?><br/>
            e-mail: <?= $profile['email']?>
        </td>
    </tr>
</table>



