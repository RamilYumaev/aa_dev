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
<p class="fs-15" align="justify">Прошу зачислить меня в порядке перевода из <?= $edu->school_name ?>,
    образовательная программа <?= $edu->speciality ?><?= $edu->specialization ? ', '.$edu->specialization:''?>,
    форма обучения <?= mb_strtolower($edu->formEdu)  ?>, <?= $edu->dictCourse->name ?> курс,
    обучаюсь на <?= $edu->finance == 1 ? 'бюджетной': 'платной' ?> основе,
    в <?=$cg->faculty->full_name ?>,
    образовательная программа
    <?= $cg->specialty->codeWithName ?><?= $cg->specialization ? ', '.$cg->specialization->name:''?>,
    форма обучения <?= mb_strtolower($cg->formEdu) ?>,
    <?= $statement->dictClass->name?> курс, семестр <?= $statement->semester ?>.
</p>
<table width="100%" class="mt-10 fs-11">
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
<?= $this->render('_block', ['message' => "Претендент может быть зачислен(а) в порядке перевода", 'about' => 'возможности зачисления в порядке перевода']) ?>
    <p class="fs-15" align="justify">
В Приемную комиссию представлена справка о периоде обучения № <?= $docPeriod->number ?> <?= $edu->school_name ?>
    </p>
