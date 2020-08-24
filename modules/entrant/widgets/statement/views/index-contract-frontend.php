<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use modules\entrant\helpers\ContractHelper;
use yii\helpers\Html;
use modules\entrant\widgets\file\FileWidget;
use modules\entrant\widgets\file\FileListWidget;

/* @var $this yii\web\View */
/* @var $contracts yii\db\BaseActiveRecord */
/* @var $agreement modules\entrant\models\StatementAgreementContractCg*/
?>
<?php if($contracts):  ?>
<div class="panel panel-default">
    <div class="panel-heading"><h4>Договор об оказании платных образовательных услуг <?=Html::a("Добавить", "/abiturient/post-document/agreement-contract")?></h4></div>
    <div class="panel-body">
        <table class="table table-bordered">
            <tr>
                <th>Образовательные программы</th>
                <th></th>
            </tr>
            <?php foreach ($contracts as $agreement):  ?>
                 <tr>
                     <td>
                         <?= $agreement->statementCg->cg->fullNameB ?>
                         <?php if($agreement->message): ?>
                             <br/> Причина отклонения: <?= $agreement->message ?>
                         <?php endif; ?>
                     </td>
                     <td>
                         <span class="label label-<?= ContractHelper::colorName($agreement->status_id) ?>">
                        <?= $agreement->statusName ?></span>

                     </td>
                 </tr>
                <?php if ($agreement->receiptContract): ?>
                <tr>
                    <td>
                        Квитанция
                        <?php if($agreement->receiptContract->message): ?>
                            <br/> Причина отклонения: <?= $agreement->receiptContract->message ?>
                        <?php endif; ?>
                    </td>
                    <td>
                         <span class="label label-<?= ContractHelper::colorName($agreement->receiptContract->status_id) ?>">
                        <?= $agreement->receiptContract->statusName ?></span>
                    </td>
                </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </table>
    </div>
</div>
<?php endif; ?>