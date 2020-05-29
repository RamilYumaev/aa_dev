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

?>
<table class="fs-15">
    <tr>
        <td width="62%"></td>
        <td>
            Председателю Приемной<br/>
            комиссии МПГУ,<br/>
            ректору МПГУ,<br/>
            А.В. Лубкову<br/>
            От: <?= $name->genitive ?? $profile['last_name'] . " " . $profile['first_name'] . " ".$profile['patronymic']?>
            <br/>
            тел.: <?= $profile['phone'] ?>
        </td>
    </tr>
</table>



