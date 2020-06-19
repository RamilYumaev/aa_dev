<?php

use backend\widgets\adminlte\Box;
use modules\entrant\helpers\BlockRedGreenHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\widgets\file\FileListBackendWidget;
use yii\helpers\Html;
use modules\entrant\widgets\file\FileWidget;
use modules\entrant\widgets\file\FileListWidget;

/* @var $this yii\web\View */
/* @var $statementConsents yii\db\BaseActiveRecord */
/* @var $consent modules\entrant\models\StatementConsentCg*/
/* @var $isAcceptedOrRecall bool */
?>
<?php if($statementConsents) : ?>
<div class="panel panel-default">
<div class="panel-heading"><h4>Заявления о согласии на зачисление <?= $isAcceptedOrRecall ? Html::a("Добавить/Отозвать", "/abiturient/post-document/consent-rejection") : ""?></h4></div>
<div class="panel-body">
        <?php foreach ($statementConsents as $consent): ?>
            <table class="table">
                <tr>
                    <th><?=$consent->statementCg->cg->fullNameB?>
                        Заявление № <?=$consent->statementCg->statement->numberStatement ?></th>
                    <td><span class="label label-<?= StatementHelper::colorName($consent->status)?>">
                                <?=$consent->statusName?></span> <br />
                        <?= ($consent->statementCgRejection ?
                        "(". "Заявление об отзыве <span class=\"label label-" . StatementHelper::colorName($consent->statementCgRejection ->status_id) . "\">" . $consent->statementCgRejection->statusName . "</span>".")" : "") ?>
                    </td>
                </tr>
            </table>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>