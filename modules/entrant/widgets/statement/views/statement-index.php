<?php
/* @var $this yii\web\View */
/* @var $statements yii\db\BaseActiveRecord */
/* @var $statement modules\entrant\models\Statement*/
/* @var $statementCg modules\entrant\models\StatementCg*/
use modules\entrant\helpers\StatementHelper;
?>
<?php if($statements): ?>
    <table class="table table-bordered">
        <?php foreach ($statements as $statement):  ?>
        <tr>
            <td>Заявление №<?= $statement->numberStatement ?>
                <?= $statement->faculty->full_name ?>/
                <?= $statement->speciality->codeWithName ?>/
                <?= $statement->eduLevel ?>/
                <?= $statement->specialRight ?>
                <span class="label label-<?= StatementHelper::colorName($statement->status)?>">
                        <?=$statement->statusName?></span>
            </td>
        </tr>
        <tr>
            <td>
             <table class="table" style="background-color: transparent">
                 <tr>
                     <th>Образовательные программы</th>
                     <th></th>
                 </tr>
                 <?php foreach ($statement->statementCg as $statementCg): ?>
                 <tr>
                    <td><?= $statementCg->cg->fullName ?></td>
                 </tr>
                 <?php endforeach; ?>
             </table>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>