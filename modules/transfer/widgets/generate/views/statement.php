<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use modules\entrant\helpers\FileHelper;
use yii\helpers\Html;
use modules\transfer\widgets\file\FileWidget;
use modules\transfer\widgets\file\FileListWidget;
/* @var $statement modules\transfer\models\StatementTransfer*/
?>
<div class="panel panel-default">
    <div class="panel-heading"><h4>Заявление</h4></div>
    <div class="panel-body">
        <table class="table table-bordered">
            <tr class="<?= BlockRedGreenHelper::colorTableBg($statement->countFiles(), $statement->count_pages) ?>">
                <td><?= Html::a('Скачать заявление', ['statement-transfer/pdf', 'id' =>  $statement->id],
                        ['class' => 'btn btn-warning'])?> <?= FileWidget::widget(['record_id' => $statement->id, 'model' => \modules\transfer\models\StatementTransfer::class ]) ?>
                </td>
                <td><?= $statement->numberStatement?></td>
            </tr>
            <tr>
                <td>
                    <?= FileListWidget::widget(['record_id' => $statement->id, 'model' => \modules\transfer\models\StatementTransfer::class,  'userId' => $statement->user_id ]) ?>
                </td>
            </tr>
        </table>
    </div>
</div>