<?php

use modules\entrant\helpers\StatementHelper;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $statementsIa yii\db\BaseActiveRecord */
/* @var $statement modules\entrant\models\StatementIndividualAchievements*/
/* @var $stIa modules\entrant\models\StatementIa */
/* @var $isUserSchool bool */
?>
<?php if($statementsIa): ?>
    <div class="panel panel-default">
    <div class="panel-heading"><h4>Заявления об учете индивидуальных достижений <?=Html::a("Добавить", "/abiturient/individual-achievements")?></h4></div>
    <div class="panel-body">
    <table class="table table-bordered">
        <?php foreach ($statementsIa as $statement):  ?>
         <tr>
            <td><?= $statement->numberStatement ?><span class="label label-<?= StatementHelper::colorName( $statement->status)?>">
                        <?= $statement->statusName?></span></td>
            <td> <?php foreach ($statement->statementIa as $key => $stIa):  ?>
                <?= ++$key ?>. <?= $stIa->dictIndividualAchievement->name ?>
                    <?php if(!$statement->isStatusWalt()) :?>
                    <span class="label label-<?= StatementHelper::colorName( $stIa->status_id)?>">
                        <?= $stIa->statusName?></span> <br/>
                    <?php endif;?>
                <?php endforeach; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    </div>
    </div>
<?php endif; ?>