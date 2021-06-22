<?php
/**
 * @var $statement modules\transfer\models\StatementTransfer
 * @var $transfer modules\transfer\models\TransferMpgu
 *  * @var $docRemove modules\transfer\models\PacketDocumentUser
 */
$transfer = $statement->transferMpgu;
$data = $transfer->getJsonData();
$docRemove = $statement->getDocumentPacket(\modules\transfer\models\PacketDocumentUser::PACKET_DOCUMENT_REMOVE);
?>
<p class="fs-15" align="justify">
Прошу восстановить меня в <?= $data['faculty'] ?>, образовательная программа <?= $data['speciality'] ?><?= $data['specialization'] ? ', '.$data['specialization']:''?>,
форма обучения <?= mb_strtolower($data['form']) ?>, <?= $data['course'] ?> курс, семестр ____ .
    <br />Приказ об отчислении  № <?= $docRemove->number ?> от <?= $docRemove->dateRu ?> г. <br />
<?= $docRemove->note ?> (причина отчисления)</p>
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
<?= $this->render('_block') ?>
<pagebreak />
<p class="fs-15">
    В Приемную комиссию представлены документы:<br/>
Копия приказа об отчислении № <?= $docRemove->number ?> от <?= $docRemove->dateRu ?> г.<br/>
    Копия зачетной книжки № <?= $transfer->number?>, выданной в <?= $transfer->year?> г.</p>
