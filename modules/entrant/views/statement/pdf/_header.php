<?php
/* @var $this yii\web\View */

use modules\entrant\helpers\PassportDataHelper;
use modules\entrant\helpers\AddressHelper;
use modules\entrant\helpers\DocumentEducationHelper;
/* @var $user_id integer */
/* @var  $profile array */


$passport = PassportDataHelper::dataArray($user_id);
$actual = AddressHelper::actual($user_id);
$reg= AddressHelper::registrationResidence($user_id);
$education = DocumentEducationHelper::dataArray($user_id)

?>
<div class="row ">
    <div class="col-xs-5">
        <table class="table table-bordered">
            <tbody>
            <tr>
                <th scope="row">Фамилия:</th>
                <td><?= $profile['last_name'] ?></td>
            </tr>
            <tr>
                <th scope="row">Имя:</th>
                <td><?= $profile['first_name'] ?></td>
            </tr>
            <?php if ($profile['patronymic']): ?>
                <tr>
                    <th scope="row">Отчество:</th>
                    <td><?= $profile['patronymic']?></td>
                </tr>
            <?php endif; ?>
            <tr>
                <th scope="row"> Дата рождения:</th>
                <td><?= $passport['date_of_birth'] ?></td>
            </tr>
            <tr>
                <th scope="row"> Контактный телефон: </th>
                <td><?= $profile['phone'] ?></td>
            </tr>
            <tr>
                <th scope="row"> E-mail:</th>
                <td><?= $profile['email'] ?></td>
            </tr>
            <tr>
                <th scope="row"> Гражданство:</th>
                <td><?= $passport['nationality'] ?></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="col-xs-offset-5">
        <table>
            <tbody>
            <tr>
                <td>Зарегистрированного(ой) по адресу: <?= $reg['full']?>
                </td>
            </tr>
            <tr>
                <td> Проживающего(ей) по адресу: <?= $actual['full']?> </td>
            </tr>
            <tr>
                <td>Документ, удостоверяющий личность: <?= $passport['type'] ?> <br />
                    серия:<?= $passport['series'] ?> <?= $passport['number'] ?>  <br />
                    выдан: <?= $passport['authority'] ?>  <br />
                    <?= $passport['date_of_issue'] ?>  <br />
                    <?= $passport['division_code'] ?  "Код подраздедения: ".$passport['division_code'] : "" ?> </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row ">
    <div class="col-xs-12">
        <p>окончившего(ей) <?= $education['year']." ".$education['school_id']." №".$education['series']." ".$education['number']?></p>
    </div>
</div>

