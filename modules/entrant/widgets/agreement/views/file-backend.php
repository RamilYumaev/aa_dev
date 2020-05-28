<?php

use backend\widgets\adminlte\Box;
use modules\entrant\helpers\BlockRedGreenHelper;
use modules\entrant\helpers\FileHelper;
use modules\entrant\widgets\file\FileWidget;
use modules\entrant\widgets\file\FileListWidget;
/* @var $model modules\entrant\models\Agreement */
?>
<?php Box::begin(
    [
        "header" => "Скан договора о целевом обучении",
        "type" => Box::TYPE_INFO,
        "filled" => true,]) ?>
<table class="table table-bordered">
    <tr>
        <th>Наименование договора</th>
    </tr>
    <tr>
        <td>
            <?= $model->documentFull ?>, <?= $model->organization ?>
        </td>
        <td>

        </td>
    </tr>
</table>
<?= FileListWidget::widget([ 'view'=>'list-backend',
    'record_id' => $model->id,
    'model' => $model::className(),
    'userId' => $model->user_id]) ?>
<?php Box::end(); ?>
