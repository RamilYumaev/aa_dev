<?php
use yii\helpers\Html;
use modules\entrant\widgets\file\FileWidget;
use modules\entrant\widgets\file\FileListWidget;
/* @var $this yii\web\View */
/* @var $statements yii\db\BaseActiveRecord */
/* @var $statement modules\entrant\models\Statement*/
/* @var $statementCg modules\entrant\models\StatementCg*/
/* @var $isUserSchool bool */
?>
<table class="table table-bordered">
    <?php foreach ($statements as $statement):  ?>
    <tr>
        <td><?= $statement->numberStatement ?>
         <table class="table">
             <tr>
                 <th>Образоватльные программы</th>
                 <th></th>
             </tr>
             <?php foreach ($statement->statementCg as $statementCg): ?>
             <tr>
                <td><?= $statementCg->cg->fullName ?></td>
                 <td><?= Html::a('Удалить', ['statement/delete-cg',
                         'id' => $statementCg->id,
                         'statement_id' => $statement->id],
                         ['class' => 'btn btn-danger', 'data-method'=>"post",
                             "data-confirm" => "Вы уверены что хотите удалить?"]) ?></td>
             </tr>
             <?php endforeach; ?>
         </table>
        </td>
        <td><?= Html::a('pdf', ['statement/pdf', 'id' =>  $statement->id],
                ['class' => 'btn btn-large btn-danger'])?> <?= FileWidget::widget(['record_id' => $statement->id, 'model' => \modules\entrant\models\Statement::class ]) ?>

            <?= FileListWidget::widget(['record_id' => $statement->id, 'model' => \modules\entrant\models\Statement::class ]) ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>