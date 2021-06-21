<?php
/* @var $statement \modules\transfer\models\StatementTransfer */
use modules\transfer\helpers\ItemsForSignatureApp;
$signaturePoint = ItemsForSignatureApp::type($statement->transferMpgu->type, $statement->edu_count)
?>
<?php foreach ($signaturePoint as $signature) :?>
    <p class="mt-15 fs-15"><?= ItemsForSignatureApp::getTransferText()[$signature] ?></p>
    <table width="100%">
        <tr>
            <td width="80%" rowspan="2"></td>
            <td class="bb"></td>
        </tr>
        <tr>
            <td class="v-align-top text-center fs-7">(подпись)
            </td>
        </tr>
    </table>
<?php endforeach; ?>