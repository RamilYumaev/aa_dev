<?php

use modules\entrant\helpers\BlockRedGreenHelper;
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
            </tr>
            <?php foreach ($contracts as $agreement):  ?>
                 <tr>
                     <td>
                         <?= $agreement->statementCg->cg->fullNameB ?>
                     </td>
                 </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
