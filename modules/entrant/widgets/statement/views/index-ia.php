<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use yii\helpers\Html;
use modules\entrant\widgets\file\FileWidget;
use modules\entrant\widgets\file\FileListWidget;
/* @var $this yii\web\View */
/* @var $statementsIa yii\db\BaseActiveRecord */
/* @var $statement modules\entrant\models\StatementIndividualAchievements*/
/* @var $stIa modules\entrant\models\StatementIa */
/* @var $isUserSchool bool */
?>
<?php if($statementsIa): ?>
    <div class="panel panel-default">
    <div class="panel-heading"><h4>Заявления об учете индивидуальных достижений</h4></div>
    <div class="panel-body">
    <table class="table table-bordered">
        <tr>
            <th>#</th>
            <th>Наименование</th>
        </tr>
        <?php foreach ($statementsIa as $statement):  ?>
        <tr class="<?= BlockRedGreenHelper::colorTableBg($statement->countFiles(), $statement->count_pages) ?>">
            <td><?= $statement->numberStatement ?></td>
            <td> <?php foreach ($statement->statementIa as $key => $stIa):  ?>
                <?= ++$key ?>. <?= $stIa->dictIndividualAchievement->name ?>
                <?php endforeach; ?>
            </td>
            <td><?= Html::a('Скачать заявление', ['statement-individual-achievements/pdf', 'id' =>  $statement->id],
                    ['class' => 'btn btn-warning'])?> <?= FileWidget::widget(['record_id' => $statement->id, 'model' => \modules\entrant\models\StatementIndividualAchievements::class ]) ?>
            </td>
        </tr>
        <tr><td colspan="3"> <?= FileListWidget::widget(['record_id' => $statement->id, 'model' => \modules\entrant\models\StatementIndividualAchievements::class, 'userId' =>$statement->user_id ]) ?></td></tr>

        <?php endforeach; ?>
    </table>

    </div>
    </div>
    <?= \modules\entrant\widgets\other\DocumentOtherFileWidget::widget(['userId' => $statement->user_id, 'ia'=> true]); ?>
<?php endif; ?>