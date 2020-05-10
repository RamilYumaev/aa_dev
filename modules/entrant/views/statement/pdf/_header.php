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
$actual = AddressHelper::actual($user_id);
$reg= AddressHelper::registrationResidence($user_id);
$education = DocumentEducationHelper::dataArray($user_id)

?>

<table width="100%">
    <tr>
        <td><?=Html::img(\Yii::$app->params["staticPath"]."/img/incoming/logo.svg")?></td>
        <td class="v-align-center text-right fs-10"><p><strong>Ректору<br/>
                    федерального государственного бюджетного образовательного учреждения высшего образования<br/>
                    «Московский педагогический государственный университет»<br/>
                    А.В.Лубкову
                </strong></p></td>
    </tr>
</table>

<table width="100%" class="mt-10">
    <tr>
        <td width="50%">Фамилия: <?= $profile['last_name'] ?><br/><br/>Имя: <?= $profile['first_name'] ?></td>
        <td><?=$profile["gender"] == ProfileHelper::genderName(ProfileHelper::MALE)
                ? "Зарегистрированного" : "Зарегистрированной"?> по адресу: <?= $reg['full']?></td>
    </tr>
    <tr>
        <td><br/><?=$profile['patronymic'] ? "Отчество: ". $profile['patronymic'] : "";?><br/><br/>
            Дата рождения: <?= $passport['date_of_birth'] ?>
        </td>
        <td><?=$profile["gender"] == ProfileHelper::genderName(ProfileHelper::MALE)
                ? "Проживающего" : "Проживающей"?> по адресу: <?= $actual['full']?></td>
    </tr>
    <tr>
        <td>
            Контактный телефон: <?= $profile['phone'] ?>
            <br/><br/>
            E-mail: <?= $profile['email'] ?>
        </td>
        <td>Документ, удостоверяющий личность: <?= $passport['type'] ?> <br />
            серия:<?= $passport['series'] ?> <?= $passport['number'] ?>  <br />
            выдан: <?= $passport['authority'] ?>  <br />
            <?= $passport['date_of_issue'] ?>  <br />
            <?= $passport['division_code'] ?  "Код подраздедения: ".$passport['division_code'] : "" ?></td>
    </tr>
    <tr>
        <td>Гражданство: <?= $passport['nationality'] ?></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="2">
            <br/><br/>
            <?=$profile["gender"] == ProfileHelper::genderName(ProfileHelper::MALE)
                ? "окончившего в " : "окончившей"?> <?= $education['year']." году ".$education['school_id']." <strong>"
            .$education['series']." ".$education['number']."</strong>"." (".$education['schoolCountyRegion'].")"?>
        </td>
    </tr>
</table>



