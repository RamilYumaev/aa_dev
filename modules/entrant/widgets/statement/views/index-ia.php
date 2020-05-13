<?php
use yii\helpers\Html;
use modules\entrant\widgets\file\FileWidget;
use modules\entrant\widgets\file\FileListWidget;
use dictionary\helpers\DictCompetitiveGroupHelper;
/* @var $this yii\web\View */
/* @var $statementsIa yii\db\BaseActiveRecord */
/* @var $statement modules\entrant\models\StatementIndividualAchievements*/
/* @var $statementCg modules\entrant\models\StatementCg*/
/* @var $isUserSchool bool */
?>
<h3>Заявления об учете индивидуальных достижений</h3>
<table class="table table-bordered">
    <tr>
        <th>Наименование</th>
    </tr>
    <?php foreach ($statementsIa as $statement):  ?>
    <tr>
        <td><?= DictCompetitiveGroupHelper::eduLevelName($statement->edu_level) ?></td>
        <td><?= Html::a('Скачать заявление', ['statement-individual-achievements/pdf', 'id' =>  $statement->id],
                ['class' => 'btn btn-warning'])?> <?= FileWidget::widget(['record_id' => $statement->id, 'model' => \modules\entrant\models\StatementIndividualAchievements::class ]) ?>

            <?= FileListWidget::widget(['record_id' => $statement->id, 'model' => \modules\entrant\models\StatementIndividualAchievements::class ]) ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>