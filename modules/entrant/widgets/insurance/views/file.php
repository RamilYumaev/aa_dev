<?php

use modules\entrant\helpers\BlockRedGreenHelper;
use modules\entrant\helpers\FileHelper;
use modules\entrant\widgets\file\FileWidget;
use modules\entrant\widgets\file\FileListWidget;

/* @var $model modules\entrant\models\InsuranceCertificateUser */
?>
    <h3>СНИЛС</h3>
<table class="table table-bordered">
    <tr>
        <th>Данные</th>
        <th><?= FileWidget::widget(['record_id' => $model->id, 'model' =>$model::className() ]) ?></th>
    </tr>
    <tr class="<?= BlockRedGreenHelper::colorTableBg($model->countFiles(), FileHelper::listCountModels()[$model::className()], true) ?>">
        <td>
            <?= $model->number ?>
        </td>
        <td>
            <?= FileListWidget::widget(['record_id' => $model->id, 'model' => $model::className(),  'userId' => $model->user_id]) ?>
        </td>
    </tr>

</table>