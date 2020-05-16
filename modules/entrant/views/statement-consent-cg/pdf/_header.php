<?php
/* @var $this yii\web\View */

use modules\entrant\helpers\PassportDataHelper;
use modules\entrant\helpers\AddressHelper;
use modules\entrant\helpers\DocumentEducationHelper;
use \olympic\helpers\auth\ProfileHelper;
use yii\helpers\Html;
/* @var $user_id integer */
/* @var  $profile array */


$passport = PassportDataHelper::dataArray($user_id);

?>

<table width="100%">
    <tr class="bg-gray"><td colspan="2" class="h-20"></td></tr>
    <tr>
        <td class="v-align-center text-center"><?=Html::img(\Yii::$app->params["staticPath"]."/img/incoming/logo.svg")?></td>
        <td class="v-align-center text-left"><p class="fs-20">В ПОДКОМИССИЮ ПО УЧЕТУ <br/>ИНДИВИДУАЛЬНЫХ ДОСТИЖЕНИЙ</strong></p><br/>
            <p class="mt-10">Фамилия: <?= $profile['last_name'] ?></p><br/>
            <p class="mt-10">Имя: <?= $profile['first_name'] ?></p><br/>
            <p class="mt-10"><?=$profile['patronymic'] ? "Отчество: ". $profile['patronymic'] : "";?></p><br/>
            <p class="mt-10" >Контактный телефон: <?= $profile['phone'] ?></p><br/>
            <p class="mt-10">Дата рождения: <?= $passport['date_of_birth'] ?></p>
        </td>
    </tr>
</table>



