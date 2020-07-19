<?php

use modules\entrant\helpers\DocumentEducationHelper;
use modules\entrant\helpers\PassportDataHelper;
use olympic\helpers\auth\ProfileHelper;
/**
 * @var $other \modules\entrant\models\OtherDocument
 */

$tpguCg = \dictionary\models\DictCompetitiveGroup::find()->andWhere(['tpgu_status'=>1])->one();

$profile = ProfileHelper::dataArray($other->user_id);
$name = \common\auth\helpers\DeclinationFioHelper::userDeclination($other->user_id);
$cg = \dictionary\helpers\DictCompetitiveGroupHelper::dataArray($tpguCg->id);
$passport = \modules\entrant\helpers\PassportDataHelper::dataArray($other->user_id);
$education = DocumentEducationHelper::dataArray($other->user_id);

$passport = PassportDataHelper::dataArray($other->user_id);
$nameFull = $profile['last_name'] . " " . $profile['first_name'] . " ".$profile['patronymic'];

?>
<table class="fs-15">
    <tr>
        <td width="70%"></td>
        <td>
            Председателю Приемной<br/>
            комиссии МПГУ,<br/>
            ректору МПГУ,<br/>
            А.В. Лубкову<br/>
            От: <?= $nameFull?>
            <br/>
            тел.: <?= $profile['phone'] ?>
        </td>
    </tr>
</table>


<div class="mt-200 fs-15">
    <p align="center">заявление.</p>


    <p align="justify" class="lh-1-5">
        Я, <?=$nameFull?>, паспорт <?=$passport['series']?> <?=$passport['number']?>  <?=$passport['authority']?>  <?=$passport['date_of_issue']?>
        прошу разрешить дистанционное заключение договора об оказании платных образовательных услуг.
    </p>
    <p align="justify">
        Факультет/институт: <?= $cg['faculty']?>,
    </p>

    <p align="justify">
        направление подготовки: <?= $cg['specialty']?>,
    </p>

    <p align="justify">
        профиль: <?= $cg['specialization']?>,
    </p>

    <p align="justify">
        форма обучение: <?= $cg['edu_form']?>.
    </p>

    <p align="justify">Со стоимостью обучения, условиями договора и порядком оплаты
        <?= $profile['gender'] == "мужской" ? "ознакомлен" : "ознакомлена" ?>.</p>

    <p align="justify">Копии документов (паспорт поступающего, паспорт заказчика, заявление о согласии на зачисление)
        прилагаю.</p>
    <table width="100%" class="mt-50 fs-15">
        <tr>
            <td></td>
            <td width="15%"><?=date("d.m.Y")?> г.</td>
            <td class="bb" width="35%"></td>
            <td width="30%"><?= $nameFull ?></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td width="15%"></td>
            <td width="35%" class="v-align-top text-center">(подпись поступающего)</td>
            <td width="30%"></td>
            <td></td>
        </tr>
    </table>
</div>