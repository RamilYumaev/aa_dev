<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use modules\entrant\widgets\file\FileWidget;
use modules\entrant\widgets\file\FileListWidget;
use dictionary\helpers\DictCompetitiveGroupHelper;
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
            <td><?= $statement->numberStatement ?></td>
            <td> <?php foreach ($statement->statementIa as $key => $stIa):  ?>
                <?= ++$key ?>. <?= $stIa->dictIndividualAchievement->name ?>
                <?php endforeach; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    </div>
    </div>
<?php endif; ?>