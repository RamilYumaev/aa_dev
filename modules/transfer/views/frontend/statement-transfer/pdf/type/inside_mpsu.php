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
Прошу перевести меня из <?= $data['faculty_genitive'] ?>
образовательная программа <?= $data['speciality'] ?><?= $data['specialization'] ? ', '.$data['specialization']:''?>
форма обучения <?= mb_strtolower($data['form']) ?>, <?= $data['course'] ?> , семестр _____
обучаюсь на <?= $data['finance'] == 1 ? 'бюджетной': 'финасовой' ?> основе
в <?=$cg->faculty->full_name ?>
образовательная программа <?= $cg->specialty->codeWithName ?><?= $cg->specialization ? ', '.$cg->specialization->name:''?>
форма обучения <?= mb_strtolower($cg->formEdu) ?>, <?= $statement->dictClass->name?>, семестр <?= $statement->semester ?>
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
В Приемную комиссию представлены документы:
Копия зачетной книжки № <?= $transfer->number?>, выданной в <?= $transfer->number?> г.
