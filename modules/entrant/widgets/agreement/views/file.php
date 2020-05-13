<?php
use modules\entrant\widgets\file\FileWidget;
use modules\entrant\widgets\file\FileListWidget;
/* @var $model modules\entrant\models\Agreement */
?>
<table class="table table-bordered">
    <tr>
        <th>Договор о целевом обучении</th>
        <th><?= FileWidget::widget(['record_id' => $model->id, 'model' =>$model::className() ]) ?></th>
    </tr>
    <tr>
        <td>
            <?= $model->documentFull ?>, <?= $model->organization ?>
        </td>
        <td>
            <?= FileListWidget::widget(['record_id' => $model->id, 'model' => $model::className()]) ?>
        </td>
    </tr>

</table>