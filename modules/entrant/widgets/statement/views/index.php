<?php
use yii\helpers\Html;
use modules\entrant\widgets\file\FileWidget;
use modules\entrant\widgets\file\FileListWidget;
use modules\entrant\helpers\BlockRedGreenHelper;
/* @var $this yii\web\View */
/* @var $statements yii\db\BaseActiveRecord */
/* @var $statement modules\entrant\models\Statement*/
/* @var $statementCg modules\entrant\models\StatementCg*/
/* @var $isUserSchool bool */
?>
<div class="panel panel-default">
    <div class="panel-heading"></div>
    <div class="panel-body">
        <table class="table table-bordered">
            <?php foreach ($statements as $statement):  ?>
                <tr class="<?= BlockRedGreenHelper::colorTableBg($statement->countFiles(), $statement->count_pages) ?>">
                    <td><?= $statement->numberStatement ?></td>
                    <td><?= Html::a('Скачать заявление', ['statement/pdf', 'id' =>  $statement->id],
                            ['class' => 'btn btn-large btn-warning'])?> <?= FileWidget::widget(['record_id' => $statement->id, 'model' => \modules\entrant\models\Statement::class ]) ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table class="table" style="background-color: transparent">
                            <tr>
                                <th>Образовательные программы</th>
                                <th></th>
                            </tr>
                            <?php foreach ($statement->statementCg as $statementCg): ?>
                                <tr>
                                    <td><?= $statementCg->cg->fullName ?></td>
                                    <td><?= $statement->isStatusDraft() ?  Html::a('Удалить', ['statement/delete-cg',
                                            'id' => $statementCg->id,
                                            'statement_id' => $statement->id],
                                            ['class' => 'btn btn-danger', 'data-method'=>"post",
                                                "data-confirm" => "Вы уверены что хотите удалить?"]) : ""?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <?= FileListWidget::widget(['record_id' => $statement->id, 'model' => \modules\entrant\models\Statement::class, 'userId' => $statement->user_id ]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>