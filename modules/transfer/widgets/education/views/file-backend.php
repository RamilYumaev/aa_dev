<?php

use backend\widgets\adminlte\Box;
use modules\transfer\widgets\file\FileListWidget;
/* @var $model modules\entrant\models\DocumentEducation*/
?>
<?php Box::begin(
    [
        "header" => "Скан документа об образовании",
        "type" => Box::TYPE_DANGER,
        "filled" => true,]) ?>
<table class="table table-bordered">
    <tr>
        <th>Документ об образовании</th>
        <th>Тип</th>
    </tr>
    <tr>
        <td>
            <?= $model->documentFull ?>, <?= $model->schoolName ?>, <?= $model->school->countryRegion ?>
        </td>
        <td>
            <?= $model->typeName ?>
        </td>
    </tr>
</table>
<?= FileListWidget::widget([ 'view' => 'list-backend', 'record_id' => $model->id, 'model' => $model::className(), 'userId' => $model->user_id]) ?>
<?php Box::end(); ?>