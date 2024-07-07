<?php
/**
 *  @var $statement modules\transfer\models\StatementTransfer
 *  @var $transfer modules\transfer\models\TransferMpgu
 *  @var $docRemove modules\transfer\models\PacketDocumentUser
 *  @var $cg dictionary\models\DictCompetitiveGroup
 */
$transfer = $statement->transferMpgu;
$data = $transfer->getJsonData();
$docRemove = $statement->getDocumentPacket(\modules\transfer\models\PacketDocumentUser::PACKET_DOCUMENT_REMOVE);
$cg = $statement->cg;
?>
<p align="justify" class="fs-15">
    Прошу <strong>восстановить</strong> меня в <?= $data['faculty'] ?>,
    образовательная программа <?= $data['speciality'] ?><?= $data['specialization'] ? ', '.$data['specialization']:''?>,
    форма обучения <?= mb_strtolower($data['form']) ?>, <?= $data['course'] ?> курс, семестр ____
    и <strong>перевести</strong> в <?=$cg->faculty->full_name ?>, образовательная программа <?= $cg->specialty->codeWithName ?><?= $cg->specialization ? ', '.$cg->specialization->name:''?>,
    форма обучения <?= mb_strtolower($cg->formEdu) ?>,
    <?= $statement->dictClass->name?> курс, семестр <?= $statement->semester ?>. <br/>
Приказ об отчислении  № <?= $docRemove->number ?> от <?= $docRemove->dateRu ?> г.
    <?= $docRemove->listCauses()[$docRemove->cause_id].($docRemove->cause_id == 5 ? '. '.$docRemove->note:'') ?> (причина отчисления)</p>
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
<?= $this->render('_block', ['message' => "Претендент может быть восстановлен(а) и переведен(а)", 'about' => 'возможности восстановления и перевода']) ?>
<p align="justify" class="fs-15">В Приемную комиссию представлены документы:<br/>
Копия приказа об отчислении № <?= $docRemove->number ?> от <?= $docRemove->dateRu ?> г. <br />
Копия зачетной книжки № <?= $transfer->number?>, выданной в <?= $transfer->year?> г.
</p>
