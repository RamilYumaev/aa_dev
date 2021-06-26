<?php

use backend\widgets\adminlte\Box;

?>
<?php Box::begin(
    [
        "header" => "СНИЛС",
        "type" => Box::TYPE_INFO,
        "filled" => true,]) ?>
<?php if($model) :?>
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

<?= \modules\transfer\widgets\file\FileListBackendWidget::Widget([ 'view'=>'list-backend',
    'record_id' => $model->id,
    'model' => $model::className(),
    'userId' => $model->user_id]) ?>
<?php  endif;?>
<?php Box::end(); ?>

