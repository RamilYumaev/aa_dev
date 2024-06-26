<?php

use backend\widgets\adminlte\Box;
use yii\helpers\Html;

?>
<?php if($model) { Box::begin(
    [
        "header" => "СНИЛС",
        "type" => Box::TYPE_INFO,
        "filled" => true,]) ?>
<table class="table table-bordered">
    <tr>
        <th>Данные</th>
    </tr>
    <tr>
        <td>
            <?= $model->number ?>
        </td>
    </tr>
</table>

<?= \modules\entrant\widgets\file\FileListBackendWidget::Widget([ 'view'=>'list-backend',
    'record_id' => $model->id,
    'model' => $model::className(),
    'userId' => $model->user_id]) ?>
<?php Box::end(); } ?>