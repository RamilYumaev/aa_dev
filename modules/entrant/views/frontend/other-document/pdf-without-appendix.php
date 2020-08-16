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
            Начальнику Управления по организации приема<br/>
            поступающих в МПГУ,<br/>
            Князевой О.Ю.
        </td>
    </tr>
</table>


<div class="mt-200 fs-15">
    <p align="center">заявление.</p>


    <p align="justify" class="lh-1-5">
        Я, <?=$nameFull?>, паспорт <?=$passport['series']?> <?=$passport['number']?>  <?=$passport['authority']?>  <?=$passport['date_of_issue']?>
        сдаю в приемную комиссию МПГУ <?=$education['type']?> <?=$education['series']?> <?=$education['number']?>,
        выданный <?=$education['school_id']?> от <?=Yii::$app->formatter->asDate($education['date'])?>.
    </p>
    <p align="justify">
        БЕЗ ПРИЛОЖЕНИЯ | БЕЗ ОБЛОЖКИ (нужное подчеркнуть).
    </p>
    <table width="100%" class="mt-50 fs-15">
        <tr>
            <td></td>
            <td width="10%"><?=date("d.m.Y")?> г.</td>
            <td class="bb" width="30%"></td>
            <td width="35%"><?= $nameFull ?></td>
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