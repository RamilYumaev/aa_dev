<?php

use backend\widgets\adminlte\Box;
use modules\transfer\widgets\file\FileListWidget;
/* @var $statement modules\entrant\models\Statement*/
/* @var $model modules\entrant\models\PassportData*/
?>
<?php Box::begin(
    [
        "header" => "Скан документа, удостоверяющего личность",
        "type" => Box::TYPE_SUCCESS,
        "filled" => true,]) ?>
<table class="table table-bordered">
    <tr>
        <th>Документ, удостоверяющий личность</th>
        <th>Тип</th>
    </tr>
    <tr>
        <td>
            <?= $model->passportFull ?>
        </td>
        <td>
            <?= $model->typeName ?>
        </td>
    </tr>
    <tr>
    </tr>
</table>
<?= FileListWidget::widget([ 'view'=>'list-backend', 'record_id' => $model->id, 'model' => $model::className(), 'userId' => $model->user_id]) ?>
<?php Box::end(); ?>
