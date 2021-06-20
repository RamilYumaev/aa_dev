<?php
/**
 *  @var $statement modules\transfer\models\StatementTransfer
 *  @var $edu modules\transfer\models\CurrentEducation
 *  @var $docPeriod modules\transfer\models\PacketDocumentUser
 *  @var $cg dictionary\models\DictCompetitiveGroup
 */
$edu = $statement->currentEducation;
$docPeriod = $statement->getDocumentPacket(\modules\transfer\models\PacketDocumentUser::PACKET_DOCUMENT_PERIOD);
$cg = $statement->cg;
?>
Прошу перевести меня из <?= $edu->school_name ?>
образовательная программа <?= $edu->speciality ?> <?= $edu->specialization ? ', '.$edu->specialization:''?>
форма обучения <?= mb_strtolower($edu->formEdu)  ?>, курс<?= $edu->dictCourse->name ?>
обучаюсь на <?= $edu->finance == 1 ? 'бюджетной': 'финасовой' ?> основе
в <?=$cg->faculty->full_name ?>
образовательная программа <?= $cg->specialty->codeWithName ?><?= $cg->specialization ? ', '.$cg->specialization->name:''?>
форма обучения <?= mb_strtolower($cg->formEdu) ?>, курс<?= $statement->dictClass->name?>, семестр <?= $statement->semester ?>
<table width="100%" class="mt-50">
    <tr>
        <td width="5px">«</td>
        <td width="25px" class="bb"></td>
        <td width="5px">»</td>
        <td class="bb"></td>
        <td width="15px">202</td>
        <td width="15px" class="bb"></td>
        <td>год</td>
        <td></td>
        <td width="150px" class="bb"></td>
        <td></td>
        <td width="150px" class="bb"></td>
        <td></td>
    </tr>
    <tr>
        <td width="5px"></td>
        <td width="25px"></td>
        <td width="5px"></td>
        <td></td>
        <td width="15px"></td>
        <td width="15px"></td>
        <td></td>
        <td></td>
        <td width="150px" class="fs-7 text-center"><i>(подпись)</i></td>
        <td></td>
        <td width="150px" class="fs-7 text-center"><i>(ФИО)</i></td>
        <td></td>
    </tr>
</table>
<?= $this->render('_block') ?>

В Приемную комиссию представлена справка о периоде обучения № <?= $docPeriod->number ?>
<?= $edu->school_name ?>
