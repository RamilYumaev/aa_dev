<?php

use backend\widgets\adminlte\Box;
use modules\entrant\helpers\BlockRedGreenHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\widgets\file\FileListBackendWidget;
use yii\helpers\Html;
use modules\entrant\widgets\file\FileWidget;
use modules\entrant\widgets\file\FileListWidget;

/* @var $this yii\web\View */
/* @var $orderTransfer yii\db\BaseActiveRecord */
/* @var $order modules\entrant\models\AisOrderTransfer*/
/* @var $statementRecord yii\db\BaseActiveRecord */
/* @var $record modules\entrant\models\StatementRejectionRecord*/
/* @var $isDownload bool */
?>

<?php if($orderTransfer) : ?>
    <div class="panel panel-default">
        <div class="panel-heading"><h4>Приказы о зачислении <?= $isDownload ? "" : Html::a("Исключить", "/abiturient/post-document/rejection-record") ?></h4></div>
        <div class="panel-body">
            <?php foreach ($orderTransfer as $order): ?>
                <table class="table table-bordered">
                    <tr>
                        <td><?=$order->cg->fullNameB?></td>
                        <td>№<?= $order->order_name?> От <?= $order->order_date?></td>
                        <?php if($isDownload) : ?>
                        <td><?= Html::a('Сформировать заявление', ['statement-rejection-record/create',
                            'id' => $order->id], ['class' => 'btn btn-info pull-right',
                            'data'=> ['confirm'=>
                                "Вы уверены, что хотите сформировать заявление об исключении из приказа о зачислении?"]]) ?> </td>
                        <?php endif; ?>
                    </tr>
                </table>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
<?php if($statementRecord) : ?>
    <div class="panel panel-default">
        <div class="panel-heading"><h4>Заявления об исключении из приказа о зачислении</h4></div>
        <div class="panel-body">
            <?php foreach ($statementRecord as $record): ?>
                <table class="table table-bordered">
                    <tr>
                        <td><?=$record->cg->fullNameB ?></td>
                        <td>№<?= $record->order_name?> От <?= $record->order_date?></td>
                        <td><span class="label label-<?= StatementHelper::colorName($record->status)?>">
                                <?=$record->statusName?></span> <br />
                           <?= ($record->pdf_file ? Html::a("Скачать файл", ['/abiturient/statement-rejection-record/get', 'id' => $record->id], ["class" => "btn btn-info btn-block"]) : "") ?>
                        </td>
                    </tr>
                   <?php if($isDownload) : ?>
                       <tr>
                           <td colspan="3">
                               <?= Html::a('Скачать заявление', ['statement-rejection-record/pdf', 'id' => $record->id],
                                   ['class' => 'btn btn-large btn-warning']) ?>
                               <?= $record->statusDraft() ? Html::a('Удалить', ['statement-rejection-record/delete',
                                   'id' => $record->id,],
                                   ['class' => 'btn btn-danger', 'data-method' => "post",
                                       "data-confirm" => "Вы уверены что хотите удалить?"]) : "" ?>
                               <?= FileWidget::widget(['record_id' => $record->id, 'model' => \modules\entrant\models\StatementRejectionRecord::class]) ?>
                           </td>
                       </tr>
                   <tr>
                       <td colspan="3">
                           <?= FileListWidget::widget(['record_id' => $record->id, 'model' => \modules\entrant\models\StatementRejectionRecord::class, 'userId' => $record->user_id ]) ?>
                       </td>
                   </tr>
                   <?php endif; ?>
                </table>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>