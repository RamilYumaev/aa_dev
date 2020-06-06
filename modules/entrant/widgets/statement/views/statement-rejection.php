<?php
/* @var $this yii\web\View */
/* @var $statements yii\db\BaseActiveRecord */
/* @var $statement modules\entrant\models\Statement*/
/* @var $statementCg modules\entrant\models\StatementCg*/
use modules\entrant\helpers\StatementHelper;
use modules\entrant\widgets\file\FileListWidget;
use modules\entrant\widgets\file\FileWidget;
use yii\helpers\Html;

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
        <?php if($statement->isStatusAccepted()) : ?>
            <tr>
                <td><?= $statement->statementRejection ?
                        Html::a("Удалить отзыв", ['statement/rejection-remove', 'id' =>  $statement->statementRejection->id], ['class'=> 'btn btn-danger', 'data' =>[
                            'confirm'  => "Вы уверены, что хотите отозвать заявление?",
                            'method'=> 'post']]) :
                        Html::a("Отозввть", ['statement/rejection', 'id' =>  $statement->id], ['class'=> 'btn btn-info', 'data' =>[
                        'confirm'  => "Вы уверены, что хотите отозвать заявление?",
                        'method'=> 'post']]) ?>
                </td>
            </tr>
        <?php endif; ?>
            <?php if($statement->statementRejection) : ?>
                <tr>
                    <td>
                    <td><?= Html::a('Скачать заявление', ['statement-rejection/pdf', 'id' =>  $statement->statementRejection->id],
                            ['class' => 'btn btn-large btn-warning'])?> <?= FileWidget::widget([
                                    'record_id' => $statement->statementRejection->id, 'model' => \modules\entrant\models\StatementRejection::class ]) ?>
                    </td>
                </tr>
                <tr>
                <td colspan="2">
                    <?= FileListWidget::widget([ 'record_id' =>$statement->statementRejection->id, 'model' => \modules\entrant\models\StatementRejection::class, 'userId' => $statement->user_id ]) ?>
                </td>
                </tr>
            <?php endif; ?>
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
                     <?php if(count($statement->statementCg) > 0 &&
                         $statement->isStatusAccepted()) : ?>
                     <td>
                         <?= Html::a('Скачать заявление', ['statement-rejection/pdf-cg', 'id' =>  $statementCg->id],
                         ['class' => 'btn btn-large btn-warning'])?> <?= FileWidget::widget([ 'record_id' => $statementCg->id,
                             'model' => \modules\entrant\models\StatementCg::class, ]) ?>
                     </td>
                         <td colspan="2">
                             <?= FileListWidget::widget(['record_id' =>$statementCg->id,
                                 'model' => \modules\entrant\models\StatementCg::class, 'userId' => $statement->user_id ]) ?>
                         </td>
                     <?php endif; ?>
                 </tr>
                 <?php endforeach; ?>
             </table>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>